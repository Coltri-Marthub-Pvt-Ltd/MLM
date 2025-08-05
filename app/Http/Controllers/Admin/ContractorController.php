<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContractorController extends Controller
{
    /**
     * Show the form for creating a new contractor.
     */
    public function create(): View
    {
        return view('admin.contractors.create');
    }

    /**
     * Store a newly created contractor.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contractors,email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:contractors,phone',
            'aadhar_card' => 'required|string|regex:/^[0-9]{12}$/|unique:contractors,aadhar_card',
            'pan_card' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/|unique:contractors,pan_card',
            'date_of_birth' => 'required|date|before:-18 years',
            'address' => 'required|string|max:1000',
            'password' => 'required|string|min:8|confirmed',
            'aadhar_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pan_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file uploads
        $aadharPhotoPath = $request->file('aadhar_photo')->store('contractors/aadhar', 'public');
        $panPhotoPath = $request->file('pan_photo')->store('contractors/pan', 'public');

        Contractor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'aadhar_card' => $request->aadhar_card,
            'pan_card' => strtoupper($request->pan_card),
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'aadhar_photo' => $aadharPhotoPath,
            'pan_photo' => $panPhotoPath,
            'status' => false, // Default inactive
            'verified_at' => null, // Default unverified
        ]);

        return redirect()->route('admin.contractors.index')
            ->with('success', 'Contractor created successfully.');
    }

    /**
     * Display a listing of contractors.
     */
    public function index(Request $request): View
    {
        $query = Contractor::with('verifiedBy');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('aadhar_card', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', true);
            } elseif ($request->status === 'inactive') {
                $query->where('status', false);
            }
        }

        // Verification filter
        if ($request->filled('verification')) {
            if ($request->verification === 'verified') {
                $query->whereNotNull('verified_at');
            } elseif ($request->verification === 'pending') {
                $query->whereNull('verified_at');
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contractors = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.contractors.index', compact('contractors'));
    }

    /**
     * Display the specified contractor.
     */
    public function show(Contractor $contractor): View
    {
        $contractor->load('verifiedBy');
        return view('admin.contractors.show', compact('contractor'));
    }

    /**
     * Show the form for editing the specified contractor.
     */
    public function edit(Contractor $contractor): View
    {
        $contractor->load('verifiedBy');
        return view('admin.contractors.edit', compact('contractor'));
    }

    /**
     * Update the specified contractor.
     */
    public function update(Request $request, Contractor $contractor): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contractors,email,' . $contractor->id,
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:contractors,phone,' . $contractor->id,
            'aadhar_card' => 'required|string|regex:/^[0-9]{12}$/|unique:contractors,aadhar_card,' . $contractor->id,
            'pan_card' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/|unique:contractors,pan_card,' . $contractor->id,
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:1000',
            'status' => 'boolean',
        ]);

        $contractor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'aadhar_card' => $request->aadhar_card,
            'pan_card' => strtoupper($request->pan_card),
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'status' => $request->boolean('status'),
        ]);

        return redirect()->route('admin.contractors.show', $contractor)
            ->with('success', 'Contractor updated successfully.');
    }

    /**
     * Verify a contractor.
     */
    public function verify(Contractor $contractor): RedirectResponse
    {
        if (!$contractor->isVerified()) {
            $contractor->update([
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            return redirect()->back()
                ->with('success', 'Contractor verified successfully.');
        }

        return redirect()->back()
            ->with('error', 'Contractor is already verified.');
    }

    /**
     * Toggle contractor status (active/inactive).
     */
    public function toggleStatus(Contractor $contractor): RedirectResponse
    {
        $contractor->update([
            'status' => !$contractor->status,
        ]);

        $status = $contractor->status ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Contractor {$status} successfully.");
    }

    /**
     * Remove the specified contractor.
     */
    public function destroy(Contractor $contractor): RedirectResponse
    {
        // Delete uploaded photos
        if ($contractor->aadhar_photo) {
            Storage::disk('public')->delete($contractor->aadhar_photo);
        }
        if ($contractor->pan_photo) {
            Storage::disk('public')->delete($contractor->pan_photo);
        }

        $contractor->delete();

        return redirect()->route('admin.contractors.index')
            ->with('success', 'Contractor deleted successfully.');
    }
}
