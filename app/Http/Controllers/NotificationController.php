<?php

namespace App\Http\Controllers;

use App\Models\Message;
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
}
