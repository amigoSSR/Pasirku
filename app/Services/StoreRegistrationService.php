<?php

namespace App\Services;

use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class StoreRegistrationService
{
    /**
     * Get the latest store registration for a user.
     *
     * @param int $userId
     * @return Toko|null
     */
    public function getRegistration(int $userId)
    {
        return Toko::where('ID_Akun', $userId)->latest('created_at')->first();
    }

    /**
     * Validate if a user can submit a store registration.
     * Returns array with key 'allowed' (bool) and optional 'reason' and 'message'.
     *
     * @param int $userId
     * @return array
     */
    public function validateRegistration(int $userId): array
    {
        $store = $this->getRegistration($userId);

        if ($store) {
            $messages = [
                'approved' => 'Akun ini sudah memiliki toko.',
                'pending' => 'Pendaftaran toko sedang diproses admin.',
                'rejected' => 'Pendaftaran toko Anda telah ditolak. Anda tidak dapat mendaftar lagi.'
            ];

            return [
                'allowed' => false,
                'reason' => $store->Status,
                'message' => $messages[$store->Status] ?? 'Akun ini sudah pernah melakukan pendaftaran toko.'
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Register a new store or re-submit a rejected one.
     *
     * @param int $userId
     * @param array $data
     * @return Toko
     * @throws \Exception
     */
    public function register(int $userId, array $data)
    {
        $validation = $this->validateRegistration($userId);

        if (!$validation['allowed']) {
            throw new \Exception($validation['message']);
        }

        // Create a new registration (user can only ever do this once now)
        return Toko::create(array_merge($data, [
            'ID_Akun' => $userId,
            'Status' => 'pending',
            'Pendapatan_Toko' => 0,
            'Total_Pembelian' => 0,
            'Komisi_Admin' => 0,
        ]));
    }
}
