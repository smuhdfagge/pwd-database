<?php

namespace App\Http\Controllers\Plwd;

use App\Http\Controllers\Controller;
use App\Models\DisabilityType;
use App\Models\EducationLevel;
use App\Models\PlwdProfile;
use App\Models\Skill;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the PLWD dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->plwdProfile;
        
        // Load skills if profile exists
        if ($profile) {
            if ($profile->skills && is_array($profile->skills) && count($profile->skills) > 0) {
                // Check if skills are stored as IDs (numeric) or names (strings)
                $firstSkill = $profile->skills[0];
                
                if (is_numeric($firstSkill)) {
                    // Skills stored as IDs
                    $profile->skillsData = Skill::whereIn('id', $profile->skills)->get();
                } else {
                    // Skills stored as names
                    $profile->skillsData = Skill::whereIn('name', $profile->skills)->get();
                }
            } else {
                $profile->skillsData = collect(); // Empty collection if no skills
            }
        }

        return view('plwd.dashboard', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->plwdProfile ?? new PlwdProfile();
        $disabilityTypes = DisabilityType::all();
        $educationLevels = EducationLevel::all();
        $skills = Skill::all();

        return view('plwd.edit-profile', compact('profile', 'disabilityTypes', 'educationLevels', 'skills'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'state' => 'required|string',
            'lga' => 'required|string',
            'disability_type_id' => 'required|exists:disability_types,id',
            'education_level_id' => 'required|exists:education_levels,id',
            'skills' => 'nullable|array',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $profile = $user->plwdProfile ?? new PlwdProfile(['user_id' => $user->id]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::exists($profile->photo)) {
                Storage::delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('plwd.dashboard')->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload documents.
     */
    public function uploadDocument(Request $request)
    {
        $validated = $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'type' => 'required|string|in:ID Card,Medical Report,Certificate,Other',
        ]);

        $user = Auth::user();
        $profile = $user->plwdProfile;

        if (!$profile) {
            return redirect()->back()->with('error', 'Please complete your profile first.');
        }

        $file = $request->file('document');
        $filePath = $file->store('documents', 'public');

        Upload::create([
            'plwd_id' => $profile->id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'type' => $validated['type'],
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }

    /**
     * Delete a document.
     */
    public function deleteDocument($id)
    {
        $upload = Upload::findOrFail($id);

        // Check ownership
        if ($upload->plwdProfile->user_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::exists($upload->file_path)) {
            Storage::delete($upload->file_path);
        }

        $upload->delete();

        return redirect()->back()->with('success', 'Document deleted successfully!');
    }
}
