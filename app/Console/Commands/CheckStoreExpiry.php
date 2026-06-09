<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Toko;
use App\Events\StoreStatusChanged;

class CheckStoreExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek toko yang masa aktifnya sudah habis dan ubah status ke expired.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredStores = Toko::where('Status', 'approved')
            ->whereNotNull('aktif_sampai')
            ->where('aktif_sampai', '<', now()->toDateString())
            ->get();

        $count = 0;
        foreach ($expiredStores as $toko) {
            $toko->Status = 'expired';
            $toko->save();
            
            // Dispatch event to change user role back to user
            event(new StoreStatusChanged($toko->ID_Toko, 'expired', $toko->ID_Akun));
            
            $count++;
            $this->info("Toko ID {$toko->ID_Toko} dinonaktifkan (expired).");
        }

        $this->info("Selesai mengecek masa aktif toko. Total dinonaktifkan: {$count}");
    }
}
