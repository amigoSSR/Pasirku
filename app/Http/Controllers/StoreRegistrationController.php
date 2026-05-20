<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StoreRegistrationService;
use Illuminate\Support\Facades\Auth;

class StoreRegistrationController extends Controller
{
    protected $registrationService;

    /**
     * Inject the registration service.
     */
    public function __construct(StoreRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Tampilkan form pendaftaran penjual.
     */
    public function showForm()
    {
        return view('tampilaUntukUser.daftarPenjual');
    }

    /**
     * Simpan pendaftaran penjual (baru atau ajukan ulang).
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nama_Toko' => 'required|string|max:255',
            'Username' => 'required|string|max:255',
            'Lokasi_Toko' => 'required|string|max:255',
            'Email_Toko' => 'required|email|max:255',
            'Nomer_Telepon_Toko' => 'required|string|max:20',
        ]);

        try {
            // Controller level validation (requirement: "Tambahkan validasi di: controller")
            $validation = $this->registrationService->validateRegistration(Auth::id());
            if (!$validation['allowed']) {
                return redirect()->route('Profil')->with('error', $validation['message']);
            }

            $this->registrationService->register(Auth::id(), [
                'Nama_Toko' => $request->Nama_Toko,
                'Username' => $request->Username,
                'Lokasi_Toko' => $request->Lokasi_Toko,
                'Email_Toko' => $request->Email_Toko,
                'Nomer_Telepon_Toko' => $request->Nomer_Telepon_Toko,
            ]);

            return redirect()->route('Profil')->with('success', 'Pendaftaran toko berhasil diajukan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
