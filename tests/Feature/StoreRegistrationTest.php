<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Toko;
use App\Services\StoreRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $storeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storeService = $this->app->make(StoreRegistrationService::class);
    }

    /**
     * Test store registration validation for new user.
     */
    public function test_new_user_can_register_store(): void
    {
        $user = User::create([
            'Username' => 'buyer123',
            'Email' => 'buyer@example.com',
            'Nomer_Telepon' => '08123456789',
            'Password' => 'password123',
            'Role' => 'user',
        ]);

        $validation = $this->storeService->validateRegistration($user->ID_Akun);
        $this->assertTrue($validation['allowed']);
    }

    /**
     * Test user cannot register if they have a pending store.
     */
    public function test_user_cannot_register_if_has_pending_store(): void
    {
        $user = User::create([
            'Username' => 'buyer123',
            'Email' => 'buyer@example.com',
            'Nomer_Telepon' => '08123456789',
            'Password' => 'password123',
            'Role' => 'user',
        ]);

        Toko::create([
            'ID_Akun' => $user->ID_Akun,
            'Nama_Toko' => 'Toko Pending',
            'Nomer_Telepon_Toko' => '0899999999',
            'Email_Toko' => 'tokopending@example.com',
            'Lokasi_Toko' => 'Surabaya',
            'Username' => 'tokopending',
            'Status' => 'pending',
        ]);

        $validation = $this->storeService->validateRegistration($user->ID_Akun);
        $this->assertFalse($validation['allowed']);
        $this->assertEquals('pending', $validation['reason']);
        $this->assertEquals('Pendaftaran toko sedang diproses admin.', $validation['message']);

        // Check Exception is thrown if they attempt to register
        $this->expectException(\Exception::class);
        $this->storeService->register($user->ID_Akun, [
            'Nama_Toko' => 'Toko Baru',
            'Nomer_Telepon_Toko' => '08111111111',
            'Email_Toko' => 'newstore@example.com',
            'Lokasi_Toko' => 'Malang',
            'Username' => 'tokobaru',
        ]);
    }

    /**
     * Test user cannot register if they have an approved store.
     */
    public function test_user_cannot_register_if_has_approved_store(): void
    {
        $user = User::create([
            'Username' => 'buyer123',
            'Email' => 'buyer@example.com',
            'Nomer_Telepon' => '08123456789',
            'Password' => 'password123',
            'Role' => 'user',
        ]);

        Toko::create([
            'ID_Akun' => $user->ID_Akun,
            'Nama_Toko' => 'Toko Approved',
            'Nomer_Telepon_Toko' => '0899999999',
            'Email_Toko' => 'tokoapproved@example.com',
            'Lokasi_Toko' => 'Surabaya',
            'Username' => 'tokoapproved',
            'Status' => 'approved',
        ]);

        $validation = $this->storeService->validateRegistration($user->ID_Akun);
        $this->assertFalse($validation['allowed']);
        $this->assertEquals('approved', $validation['reason']);
        $this->assertEquals('Akun ini sudah memiliki toko.', $validation['message']);
    }

    /**
     * Test user cannot register if they have a rejected store.
     */
    public function test_user_cannot_register_if_has_rejected_store(): void
    {
        $user = User::create([
            'Username' => 'buyer123',
            'Email' => 'buyer@example.com',
            'Nomer_Telepon' => '08123456789',
            'Password' => 'password123',
            'Role' => 'user',
        ]);

        $rejectedStore = Toko::create([
            'ID_Akun' => $user->ID_Akun,
            'Nama_Toko' => 'Toko Ditolak',
            'Nomer_Telepon_Toko' => '0899999999',
            'Email_Toko' => 'tokorejected@example.com',
            'Lokasi_Toko' => 'Surabaya',
            'Username' => 'tokorejected',
            'Status' => 'rejected',
        ]);

        // Validate re-registration is NOT allowed because it was rejected
        $validation = $this->storeService->validateRegistration($user->ID_Akun);
        $this->assertFalse($validation['allowed']);
        $this->assertEquals('rejected', $validation['reason']);
        $this->assertEquals('Pendaftaran toko Anda telah ditolak. Anda tidak dapat mendaftar lagi.', $validation['message']);
    }

    /**
     * Test middleware blocks access to registration form for pending, approved, and rejected stores.
     */
    public function test_middleware_blocks_stores_from_form(): void
    {
        $user = User::create([
            'Username' => 'buyer123',
            'Email' => 'buyer@example.com',
            'Nomer_Telepon' => '08123456789',
            'Password' => 'password123',
            'Role' => 'user',
        ]);

        // 1. Pending store redirects to Profil
        $store = Toko::create([
            'ID_Akun' => $user->ID_Akun,
            'Nama_Toko' => 'Toko Pending',
            'Nomer_Telepon_Toko' => '0899999999',
            'Email_Toko' => 'tokopending@example.com',
            'Lokasi_Toko' => 'Surabaya',
            'Username' => 'tokopending',
            'Status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/daftarPenjual');
        $response->assertRedirect(route('Profil'));
        $response->assertSessionHas('error', 'Pendaftaran toko sedang diproses admin.');

        // 2. Approved store redirects to MenuUtamaStore
        $store->update(['Status' => 'approved']);

        $response = $this->actingAs($user)->get('/daftarPenjual');
        $response->assertRedirect(route('MenuUtamaStore'));
        $response->assertSessionHas('error', 'Akun ini sudah memiliki toko.');
        
        // 3. Rejected store redirects to Profil
        $store->update(['Status' => 'rejected']);

        $response = $this->actingAs($user)->get('/daftarPenjual');
        $response->assertRedirect(route('Profil'));
        $response->assertSessionHas('error', 'Pendaftaran toko Anda telah ditolak. Anda tidak dapat mendaftar lagi.');
    }
}
