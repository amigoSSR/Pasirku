<?php

namespace App\Listeners;

use App\Events\StoreStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StoreStatusChanged $event): void
    {
        $user = \Illuminate\Support\Facades\DB::table('informasi_akun')->where('ID_Akun', $event->idAkun)->first();
        if ($user && $user->Role === 'admin') {
            return;
        }

        $newRole = $event->status === 'active' ? 'store' : 'user';
        \Illuminate\Support\Facades\DB::table('informasi_akun')
            ->where('ID_Akun', $event->idAkun)
            ->update(['Role' => $newRole]);
    }
}
