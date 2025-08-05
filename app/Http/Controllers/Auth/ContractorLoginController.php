<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContractorLoginController extends Controller
{
    /**
     * Show the contractor login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('contractor')->check()) {
            return redirect('/contractor/dashboard');
        }
        
        return view('auth.contractor.login');
    }

    /**
     * Handle a contractor login request to the application.
     */
    public function login(Request $request): RedirectResponse
    {
        if (Auth::guard('contractor')->check()) {
            return redirect('/contractor/dashboard');
        }

        $request->validate([
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'password' => ['required', 'string'],
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $credentials = $request->only('phone', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('contractor')->attempt($credentials, $remember)) {
            $contractor = Auth::guard('contractor')->user();
            
            // Check if contractor is verified and active
            if (!$contractor->isVerified()) {
                Auth::guard('contractor')->logout();
                throw ValidationException::withMessages([
                    'phone' => ['Your account is pending verification. Please wait for admin approval.'],
                ]);
            }
            
            if (!$contractor->isActive()) {
                Auth::guard('contractor')->logout();
                throw ValidationException::withMessages([
                    'phone' => ['Your account is currently inactive. Please contact admin for assistance.'],
                ]);
            }
            
            $request->session()->regenerate();

            return redirect()->intended('/contractor/dashboard');
        }

        throw ValidationException::withMessages([
            'phone' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the contractor out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('contractor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/contractor/login');
    }
}
