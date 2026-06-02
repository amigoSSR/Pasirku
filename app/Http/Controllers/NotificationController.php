<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Dapatkan jumlah pesan/notifikasi yang belum dibaca untuk user yang login.
     */
    public function unreadCount()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        // Pesan unread di mana user adalah receiver
        $count = Message::where('receiver_id', $user->ID_Akun)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Count completed/cancelled orders that the user hasn't seen yet.
     */
    public function riwayatCount()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $query = Pesanan::where('ID_Akun', $user->ID_Akun)
            ->whereIn('Status_Pesanan', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN]);

        // Only count orders that were completed/cancelled after the user last viewed riwayat
        if ($user->riwayat_seen_at) {
            $query->where('updated_at', '>', $user->riwayat_seen_at);
        }

        return response()->json(['count' => $query->count()]);
    }
}
