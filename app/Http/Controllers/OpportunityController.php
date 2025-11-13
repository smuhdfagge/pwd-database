<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    /**
     * Display the opportunities page.
     * Access control: Only verified PLWD profiles can access.
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Please create an account or login to view opportunities.');
        }

        // Check if user is PLWD (not admin)
        if (Auth::user()->role !== 'plwd') {
            return redirect()->route('home')
                ->with('error', 'Only PLWD members can access opportunities.');
        }

        // Check if user has a profile
        $profile = Auth::user()->plwdProfile;
        if (!$profile) {
            return redirect()->route('plwd.profile.edit')
                ->with('error', 'Please complete your profile to view opportunities.');
        }

        // Check if profile is verified
        if (!$profile->verified) {
            $supportEmail = env('SUPPORT_EMAIL', config('mail.from.address', 'support@vpesdi.org'));
            return view('opportunities.unverified', compact('supportEmail'));
        }

        // User is verified, fetch active opportunities
        $opportunities = Opportunity::active()
            ->notExpired()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('opportunities.index', compact('opportunities'));
    }

    /**
     * Display a single opportunity
     */
    public function show($id)
    {
        // Check if user is logged in and verified
        if (!Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Please create an account or login to view opportunities.');
        }

        if (Auth::user()->role !== 'plwd') {
            return redirect()->route('home')
                ->with('error', 'Only PLWD members can access opportunities.');
        }

        $profile = Auth::user()->plwdProfile;
        if (!$profile || !$profile->verified) {
            return redirect()->route('opportunities.index')
                ->with('error', 'Your profile must be verified to view opportunity details.');
        }

        $opportunity = Opportunity::findOrFail($id);
        
        // Increment view count
        $opportunity->incrementViews();

        return view('opportunities.show', compact('opportunity'));
    }
}

