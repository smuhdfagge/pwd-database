<?php

namespace App\Services;

use App\Models\PlwdProfile;
use App\Models\Skill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate a PDF for a PLWD profile
     *
     * @param PlwdProfile $profile
     * @return \Illuminate\Http\Response
     */
    public function generateProfilePdf(PlwdProfile $profile)
    {
        // Load all necessary relationships
        $profile->load([
            'user',
            'disabilityType',
            'educationLevel',
            'educationRecords.educationLevel',
            'uploads'
        ]);

        // Process skills data
        if ($profile->skills && is_array($profile->skills) && count($profile->skills) > 0) {
            $firstSkill = $profile->skills[0];
            
            if (is_numeric($firstSkill)) {
                $profile->skillsData = Skill::whereIn('id', $profile->skills)->get();
            } else {
                $profile->skillsData = Skill::whereIn('name', $profile->skills)->get();
            }
        } else {
            $profile->skillsData = collect();
        }

        // Get photo URL if exists
        $photoUrl = null;
        if ($profile->photo) {
            $photoPath = storage_path('app/public/' . $profile->photo);
            if (file_exists($photoPath)) {
                $photoUrl = $photoPath;
            }
        }

        // Prepare data for PDF
        $data = [
            'profile' => $profile,
            'user' => $profile->user,
            'photoUrl' => $photoUrl,
            'generatedDate' => now()->format('F d, Y')
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.plwd-profile', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $fileName = 'profile_' . $profile->user->name . '_' . now()->format('Ymd') . '.pdf';
        $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $fileName);
        
        return $pdf->download($fileName);
    }
}
