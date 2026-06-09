<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ID_Pesanan'   => 'required|exists:pesanan,ID_Pesanan',
            'Rating'       => 'required|integer|min:1|max:5',
            'Ulasan'       => 'nullable|string|max:1000',
            'Foto_Review'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $pesanan = Pesanan::findOrFail($request->ID_Pesanan);

        // Security & Validation
        // 1. Only buyer can review
        if ($pesanan->ID_Akun !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk memberikan rating pada pesanan ini.');
        }

        // 2. Only completed orders (Selesai or Accepted/Diterima)
        // User said: "selesai" and "diterima". In our model, 'Selesai' is standard.
        // Let's check if 'accepted' also allowed as per user request.
        $allowedStatuses = [Pesanan::STATUS_SELESAI, 'accepted']; 
        if (!in_array($pesanan->Status_Pesanan, $allowedStatuses)) {
            return back()->with('error', 'Rating hanya dapat diberikan untuk pesanan yang sudah selesai atau diterima.');
        }

        // 3. One review per order
        if ($pesanan->review()->exists()) {
            return back()->with('error', 'Anda sudah memberikan rating untuk pesanan ini.');
        }

        $fotoPath = null;
        if ($request->hasFile('Foto_Review')) {
            $fotoPath = $request->file('Foto_Review')->store('reviews', 'public');
        }

        Review::create([
            'ID_Pesanan'   => $pesanan->ID_Pesanan,
            'ID_Akun'      => Auth::id(),
            'ID_Toko'      => $pesanan->ID_Toko,
            'Rating'       => $request->Rating,
            'Ulasan'       => $request->Ulasan,
            'Foto_Review'  => $fotoPath,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Rating'       => 'required|integer|min:1|max:5',
            'Ulasan'       => 'nullable|string|max:1000',
            'Foto_Review'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $review = Review::findOrFail($id);

        if ($review->ID_Akun !== Auth::id()) {
            abort(403);
        }

        // Optional: Time limit for editing (e.g., 7 days)
        if ($review->created_at->diffInDays(now()) > 7) {
            return back()->with('error', 'Batas waktu mengedit ulasan sudah berakhir (7 hari).');
        }

        if ($request->hasFile('Foto_Review')) {
            // Delete old photo if exists
            if ($review->Foto_Review) {
                Storage::disk('public')->delete($review->Foto_Review);
            }
            $review->Foto_Review = $request->file('Foto_Review')->store('reviews', 'public');
        }

        $review->Rating = $request->Rating;
        $review->Ulasan = $request->Ulasan;
        $review->is_anonymous = $request->has('is_anonymous');
        $review->save();

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }
}
