<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class ContractorRegisterController extends Controller
{
    /**
     * Show the contractor registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.contractor.register');
    }

    /**
     * Handle a contractor registration request to the application.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:contractors'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:contractors'],
            'aadhar_card' => ['required', 'string', 'regex:/^[0-9]{12}$/', 'unique:contractors'],
            'aadhar_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'pan_card' => ['required', 'string', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 'unique:contractors'],
            'pan_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referenced_by' => [
                'required',
                'string',
                'regex:/^[0-9]{10}$/',
                function ($attribute, $value, $fail) {
                    $ref = \App\Models\Contractor::where('phone', $value)->where('status', true)->first();
                    if (!$ref) {
                        $fail('The referenced contractor must exist and be active.');
                    }
                },
            ],
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.',
            'aadhar_card.regex' => 'Aadhar card number must be exactly 12 digits.',
            'aadhar_photo.required' => 'Aadhar card photo is required.',
            'aadhar_photo.image' => 'Aadhar card photo must be an image.',
            'aadhar_photo.mimes' => 'Aadhar card photo must be a JPEG, PNG, or JPG file.',
            'aadhar_photo.max' => 'Aadhar card photo must not exceed 2MB.',
            'pan_card.regex' => 'PAN card number must be in the format: ABCDE1234F.',
            'pan_photo.required' => 'PAN card photo is required.',
            'pan_photo.image' => 'PAN card photo must be an image.',
            'pan_photo.mimes' => 'PAN card photo must be a JPEG, PNG, or JPG file.',
            'pan_photo.max' => 'PAN card photo must not exceed 2MB.',
            'date_of_birth.before' => 'Date of birth must be a valid date in the past.',
            'password.confirmed' => 'Password confirmation does not match.',
            'referenced_by.regex' => 'Referenced By must be a valid 10-digit phone number.',
        ]);

        // Check if user is 18 or older
        $dateOfBirth = Carbon::parse($request->date_of_birth);
        $age = $dateOfBirth->age;
        
        if ($age < 18) {
            return back()
                ->withInput()
                ->withErrors(['date_of_birth' => 'You must be at least 18 years old to register.']);
        }

        // Handle file uploads
        $aadharPhotoPath = null;
        $panPhotoPath = null;

        if ($request->hasFile('aadhar_photo')) {
            $aadharPhotoPath = $request->file('aadhar_photo')->store('contractors/aadhar', 'public');
        }

        if ($request->hasFile('pan_photo')) {
            $panPhotoPath = $request->file('pan_photo')->store('contractors/pan', 'public');
        }

        // Get the referenced contractor ID (required field)
        $ref = \App\Models\Contractor::where('phone', $request->referenced_by)->where('status', true)->first();
        $referencedById = $ref->id;

        // Create contractor
        $contractor = Contractor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'aadhar_card' => $request->aadhar_card,
            'aadhar_photo' => $aadharPhotoPath,
            'pan_card' => strtoupper($request->pan_card),
            'pan_photo' => $panPhotoPath,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => false, // Default inactive
            'verified_at' => null, // Not verified by default
            'verified_by' => null, // Not verified by default
            'referenced_by' => $referencedById,
        ]);

        // Don't log in automatically - wait for admin verification
        return redirect('/contractor/login')
            ->with('success', 'Registration successful! Your account is pending verification. You will be able to login once an admin verifies your account.');
    }
}
