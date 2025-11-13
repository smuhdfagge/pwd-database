<?php

namespace App\Http\Controllers;

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

        // User is verified, show opportunities
        // TODO: Fetch actual opportunities from database when available
        $opportunities = []; // Placeholder for future opportunities

        return view('opportunities.index', compact('opportunities'));
    }
}
