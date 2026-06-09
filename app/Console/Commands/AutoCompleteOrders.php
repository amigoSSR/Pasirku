<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Models\Toko;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     */
    protected $description = 'Otomatis menyelesaikan pesanan berstatus "Dikirim" yang sudah melewati 3 hari dari tanggal pengiriman.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(3)->toDateString();

        // Cari pesanan yang statusnya "Dikirim" dan tanggal pengirimannya sudah > 3 hari lalu
        $orders = Pesanan::where('Status_Pesanan', Pesanan::STATUS_DIKIRIM)
            ->whereDate('Tanggal_Pengiriman', '<=', $cutoffDate)
            ->get();

        if ($orders->isEmpty()) {
            $this->info('Tidak ada pesanan yang perlu di-auto-complete.');
            return 0;
        }

        $count = 0;

        foreach ($orders as $pesanan) {
            try {
                DB::beginTransaction();

                $oldPaymentStatus = $pesanan->Status_Pembayaran;

                $pesanan->Status_Pesanan = Pesanan::STATUS_SELESAI;
                $pesanan->Status_Pembayaran = 'Lunas';
                $pesanan->save();

                // Update Pendapatan & Total Pembelian Toko
                $toko = Toko::where('ID_Toko', $pesanan->ID_Toko)->first();
                if ($toko && $oldPaymentStatus !== 'Lunas') {
                    if (is_null($toko->aktif_sampai)) {
                        $toko->aktif_sampai = now()->addMonth()->toDateString();
                    }
                    $toko->Pendapatan_Toko += $pesanan->total_harga;
                    $toko->Total_Pembelian += 1;
                    $toko->save();
                }

                DB::commit();

                // Kirim notifikasi chat ke pembeli
                if ($toko) {
                    $produk = $pesanan->nama_produk ?? 'produk pasir';
                    $messageText = "✅ Pesanan **{$produk}** (Order #{$pesanan->ID_Pesanan}) telah otomatis diselesaikan karena melewati batas waktu konfirmasi (3 hari setelah jadwal pengiriman). Terima kasih sudah berbelanja!";

                    // Pastikan chat room ada
                    $chatExists = Message::where('toko_id', $toko->ID_Toko)
                        ->where(function ($q) use ($pesanan, $toko) {
                            $q->where('sender_id', $toko->ID_Akun)->where('receiver_id', $pesanan->ID_Akun)
                              ->orWhere('sender_id', $pesanan->ID_Akun)->where('receiver_id', $toko->ID_Akun);
                        })->exists();

                    if (!$chatExists) {
                        Message::create([
                            'sender_id'   => $pesanan->ID_Akun,
                            'receiver_id' => $toko->ID_Akun,
                            'toko_id'     => $toko->ID_Toko,
                            'message'     => "Halo, saya memesan produk dari toko Anda (Order #{$pesanan->ID_Pesanan}).",
                            'is_read'     => true,
                        ]);
                    }

                    Message::create([
                        'sender_id'   => $toko->ID_Akun,
                        'receiver_id' => $pesanan->ID_Akun,
                        'toko_id'     => $toko->ID_Toko,
                        'message'     => $messageText,
                        'is_read'     => false,
                    ]);
                }

                $count++;
                $this->line("  ✓ Order #{$pesanan->ID_Pesanan} auto-completed.");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("AutoCompleteOrders: Gagal menyelesaikan Order #{$pesanan->ID_Pesanan}", [
                    'error' => $e->getMessage(),
                ]);
                $this->error("  ✗ Order #{$pesanan->ID_Pesanan} gagal: {$e->getMessage()}");
            }
        }

        $this->info("Selesai. {$count} pesanan berhasil di-auto-complete.");
        return 0;
    }
}
