<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Dapatkan daftar kontak/ruang obrolan berdasarkan role user
     */
    public function getRooms()
    {
        $user = Auth::user();
        $rooms = [];

        if ($user->Role === 'user') {
            // User: bisa chat dengan toko yang pernah dihubungi, dan admin
            
            // 1. Dapatkan semua toko yang pernah di-chat
            $chattedTokoIds = Message::where(function($q) use ($user) {
                $q->where('sender_id', $user->ID_Akun)
                  ->orWhere('receiver_id', $user->ID_Akun);
            })->whereNotNull('toko_id')->pluck('toko_id')->unique();

            $tokos = Toko::whereIn('ID_Toko', $chattedTokoIds)->get();
            foreach ($tokos as $toko) {
                $rooms[] = [
                    'id' => 'toko_' . $toko->ID_Toko,
                    'name' => $toko->Nama_Toko,
                    'type' => 'toko',
                    'toko_id' => $toko->ID_Toko,
                    'user_id' => $toko->ID_Akun, // ID akun pemilik toko (receiver)
                ];
            }

            // 2. Chat dengan Admin (toko_id = null)
            $chattedWithAdmin = Message::where(function($q) use ($user) {
                $q->where('sender_id', $user->ID_Akun)
                  ->orWhere('receiver_id', $user->ID_Akun);
            })->whereNull('toko_id')->exists();

            if ($chattedWithAdmin) {
                $existingMessage = Message::where(function($q) use ($user) {
                    $q->where('sender_id', $user->ID_Akun)
                      ->orWhere('receiver_id', $user->ID_Akun);
                })->whereNull('toko_id')->first();

                if ($existingMessage) {
                    $adminId = $existingMessage->sender_id === $user->ID_Akun 
                                ? $existingMessage->receiver_id 
                                : $existingMessage->sender_id;
                    
                    $rooms[] = [
                        'id' => 'admin_' . $adminId,
                        'name' => 'Customer Support',
                        'type' => 'admin',
                        'toko_id' => null,
                        'user_id' => $adminId,
                    ];
                }
            }

        } elseif ($user->Role === 'store' || $user->Role === 'seller') {
            // Store: hanya bisa chat dengan user yang pernah nge-chat tokonya
            $toko = Toko::where('ID_Akun', $user->ID_Akun)->first();
            if ($toko) {
                $chattedUserIds = Message::where('toko_id', $toko->ID_Toko)
                    ->where('sender_id', '!=', $user->ID_Akun)
                    ->pluck('sender_id')->unique();

                $users = User::whereIn('ID_Akun', $chattedUserIds)->get();
                foreach ($users as $u) {
                    $rooms[] = [
                        'id' => 'user_' . $u->ID_Akun,
                        'name' => $u->Username,
                        'type' => 'user',
                        'toko_id' => $toko->ID_Toko,
                        'user_id' => $u->ID_Akun,
                    ];
                }
            }

        } elseif ($user->Role === 'admin' || $user->Role === 'cs') {
            // Admin/CS: chat dengan semua user yang nge-chat admin/cs
            $chattedUserIds = Message::whereNull('toko_id')
                ->where('sender_id', '!=', $user->ID_Akun)
                ->pluck('sender_id')->unique();

            $users = User::whereIn('ID_Akun', $chattedUserIds)->get();
            foreach ($users as $u) {
                $rooms[] = [
                    'id' => 'user_' . $u->ID_Akun,
                    'name' => $u->Username,
                    'type' => 'user',
                    'toko_id' => null,
                    'user_id' => $u->ID_Akun,
                ];
            }
        }

        return response()->json($rooms);
    }

    /**
     * Dapatkan pesan untuk ruang obrolan tertentu
     */
    public function getMessages(Request $request)
    {
        $user = Auth::user();
        $tokoId = $request->query('toko_id');
        $otherUserId = $request->query('user_id'); // ID user/admin yang diajak chat

        $query = Message::query();

        if ($tokoId) {
            $query->where('toko_id', $tokoId);
            // Ambil percakapan antara saya dan user lain untuk toko tertentu
            $query->where(function($q) use ($user, $otherUserId) {
                $q->where(function($q1) use ($user, $otherUserId) {
                    $q1->where('sender_id', $user->ID_Akun)->where('receiver_id', $otherUserId);
                })->orWhere(function($q2) use ($user, $otherUserId) {
                    $q2->where('sender_id', $otherUserId)->where('receiver_id', $user->ID_Akun);
                });
            });
        } else {
            $query->whereNull('toko_id');
            // Jika chat CS (toko_id null):
            if ($user->Role === 'admin' || $user->Role === 'cs') {
                // CS/Admin dapat melihat semua chat dari user yang bersangkutan dengan semua CS/Admin
                $query->where(function($q) use ($otherUserId) {
                    $q->where('sender_id', $otherUserId)
                      ->orWhere('receiver_id', $otherUserId);
                });
            } else {
                // User biasa melihat semua chatnya dengan CS/Admin siapapun
                $query->where(function($q) use ($user) {
                    $q->where('sender_id', $user->ID_Akun)
                      ->orWhere('receiver_id', $user->ID_Akun);
                });
            }
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Tandai pesan sebagai dibaca (kalau saya penerimanya atau ini inbox CS)
        if ($user->Role === 'admin' || $user->Role === 'cs') {
            Message::whereIn('id', $messages->pluck('id'))
                ->where('sender_id', $otherUserId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            Message::whereIn('id', $messages->pluck('id'))
                ->where('receiver_id', $user->ID_Akun)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json($messages);
    }

    /**
     * Kirim pesan baru
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'toko_id' => 'nullable|integer',
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        // Security Check: 
        // 1. Jika Role Store, pastikan toko_id adalah miliknya
        if ($user->Role === 'store' || $user->Role === 'seller') {
            $toko = Toko::where('ID_Akun', $user->ID_Akun)->first();
            if (!$toko || $toko->ID_Toko != $request->toko_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        // 2. Jika Admin atau CS, pastikan toko_id null
        if ($user->Role === 'admin' || $user->Role === 'cs') {
            if ($request->toko_id !== null) {
                return response()->json(['error' => 'Admin/CS cannot chat as store'], 403);
            }
        }

        $message = Message::create([
            'sender_id' => $user->ID_Akun,
            'receiver_id' => $request->receiver_id,
            'toko_id' => $request->toko_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json($message);
    }

    /**
     * Mulai chat dengan toko (dari halaman profil toko / produk)
     * Ini dipanggil via method POST/GET dari web, kemudian redirect ke halaman chat
     */
    public function startChatWithToko($id)
    {
        $toko = Toko::findOrFail($id);
        $user = Auth::user();

        // Pastikan user tidak chat tokonya sendiri
        if ($toko->ID_Akun === $user->ID_Akun) {
            return back()->with('error', 'Anda tidak dapat mengobrol dengan toko Anda sendiri.');
        }

        // Cek apakah sudah ada pesan
        $exists = Message::where('toko_id', $toko->ID_Toko)
            ->where(function($q) use ($user, $toko) {
                $q->where('sender_id', $user->ID_Akun)->where('receiver_id', $toko->ID_Akun)
                  ->orWhere('sender_id', $toko->ID_Akun)->where('receiver_id', $user->ID_Akun);
            })->exists();

        if (!$exists) {
            // Buat pesan awal otomatis agar room terbentuk dan muncul di daftar kontak (getRooms)
            Message::create([
                'sender_id' => $user->ID_Akun,
                'receiver_id' => $toko->ID_Akun,
                'toko_id' => $toko->ID_Toko,
                'message' => 'Halo, saya tertarik dengan produk Anda.',
                'is_read' => false
            ]);
        }

        // Redirect ke halaman chat dan otomatis buka room toko ini
        return redirect()->route('Pesan')->with('open_chat_toko', $toko->ID_Toko);
    }

    /**
     * Mulai chat dengan Admin (Customer Service)
     */
    public function startChatWithAdmin(Request $request)
    {
        $user = Auth::user();

        // Cek apakah user sudah punya riwayat chat dengan CS/Admin sebelumnya
        $existingMessage = Message::whereNull('toko_id')
            ->where(function($q) use ($user) {
                $q->where('sender_id', $user->ID_Akun)
                  ->orWhere('receiver_id', $user->ID_Akun);
            })->first();

        if ($existingMessage) {
            $adminId = $existingMessage->sender_id === $user->ID_Akun 
                        ? $existingMessage->receiver_id 
                        : $existingMessage->sender_id;
            $admin = User::find($adminId);
        } else {
            // Jika belum ada, assign hanya ke CS acak
            $admin = User::where('Role', 'cs')->inRandomOrder()->first();
        }

        if (!$admin) {
            return back()->with('error', 'Layanan Customer Service sedang tidak tersedia.');
        }

        // Pastikan user tidak chat dirinya sendiri jika dia admin/cs
        if ($admin->ID_Akun === $user->ID_Akun) {
            return back()->with('error', 'Anda adalah CS/Admin.');
        }

        $initialMessage = $request->query('initial_msg', 'Halo Customer Service, saya butuh bantuan.');

        // Cek apakah sudah ada pesan
        $exists = Message::whereNull('toko_id')
            ->where(function($q) use ($user, $admin) {
                $q->where('sender_id', $user->ID_Akun)->where('receiver_id', $admin->ID_Akun)
                  ->orWhere('sender_id', $admin->ID_Akun)->where('receiver_id', $user->ID_Akun);
            })->exists();

        if (!$exists || $request->has('initial_msg')) {
            Message::create([
                'sender_id' => $user->ID_Akun,
                'receiver_id' => $admin->ID_Akun,
                'toko_id' => null,
                'message' => $initialMessage,
                'is_read' => false
            ]);
        }

        return redirect()->route('Pesan')->with('open_chat_admin', $admin->ID_Akun);
    }
}
