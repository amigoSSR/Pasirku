<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\StoreRegistrationService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfHasStore
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
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $validation = $this->registrationService->validateRegistration(Auth::id());

            if (!$validation['allowed']) {
                if ($validation['reason'] === 'approved') {
                    return redirect()->route('MenuUtamaStore')->with('error', $validation['message']);
                }

                return redirect()->route('Profil')->with('error', $validation['message']);
            }
        }

        return $next($request);
    }
}
