<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            
            if ($user->Role === 'store' || $user->Role === 'seller') {
                $toko = \Illuminate\Support\Facades\DB::table('informasi_toko')
                    ->where('ID_Akun', $user->ID_Akun)
                    ->first();
                
                if ($toko && $toko->Status !== 'approved') {
                    // Update role back to user if store is inactive/not approved
                    \Illuminate\Support\Facades\DB::table('informasi_akun')
                        ->where('ID_Akun', $user->ID_Akun)
                        ->update(['Role' => 'user']);
                    
                    // Logout because login as store is rejected/not approved
                    \Illuminate\Support\Facades\Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'Email' => 'Toko Anda belum aktif atau ditolak. Login sebagai toko ditolak.',
                    ]);
                }
            }
        }

        return $next($request);
    }
}
