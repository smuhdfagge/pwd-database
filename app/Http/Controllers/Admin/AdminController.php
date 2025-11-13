<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\DisabilityType;
use App\Models\EducationLevel;
use App\Models\PlwdProfile;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\ProfileApproved;
use App\Notifications\ProfileRejected;
use App\Services\AuditService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlwdExport;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // All registered users
        $totalUsers = User::where('role', 'plwd')->count();
        $usersWithoutProfile = User::where('role', 'plwd')->doesntHave('plwdProfile')->count();
        
        // Profile statistics
        $totalPlwds = PlwdProfile::count();
        $verifiedPlwds = PlwdProfile::where('verified', true)->count();
        $pendingPlwds = PlwdProfile::where('verified', false)->count();
        
        $plwdsByDisability = PlwdProfile::with('disabilityType')
            ->get()
            ->groupBy('disability_type_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->disabilityType->name ?? 'Unknown',
                    'count' => $group->count()
                ];
            });

        $plwdsByEducation = PlwdProfile::with('educationLevel')
            ->get()
            ->groupBy('education_level_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->educationLevel->name ?? 'Unknown',
                    'count' => $group->count()
                ];
            });

        $plwdsByGender = PlwdProfile::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->get();

        $plwdsByState = PlwdProfile::selectRaw('state, count(*) as count')
            ->groupBy('state')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        $recentRegistrations = PlwdProfile::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent users without profiles
        $recentUsersWithoutProfile = User::where('role', 'plwd')
            ->doesntHave('plwdProfile')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'usersWithoutProfile',
            'totalPlwds',
            'verifiedPlwds',
            'pendingPlwds',
            'plwdsByDisability',
            'plwdsByEducation',
            'plwdsByGender',
            'plwdsByState',
            'recentRegistrations',
            'recentUsersWithoutProfile'
        ));
    }

    /**
     * Display a list of all registered users.
     */
    public function listUsers(Request $request)
    {
        $query = User::with('plwdProfile')->where('role', 'plwd');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('has_profile')) {
            if ($request->has_profile === 'yes') {
                $query->has('plwdProfile');
            } else {
                $query->doesntHave('plwdProfile');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a list of all PLWDs with filters.
     */
    public function listPlwds(Request $request)
    {
        $query = PlwdProfile::with(['user', 'disabilityType', 'educationLevel']);

        // Apply filters
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('disability_type')) {
            $query->where('disability_type_id', $request->disability_type);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('verified')) {
            $query->where('verified', $request->verified);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $plwds = $query->paginate(20);

        $disabilityTypes = DisabilityType::all();
        $states = PlwdProfile::select('state')->distinct()->pluck('state');

        return view('admin.plwds.index', compact('plwds', 'disabilityTypes', 'states'));
    }

    /**
     * Show a specific PLWD profile.
     */
    public function show($id)
    {
        $profile = PlwdProfile::with(['user', 'disabilityType', 'educationLevel', 'uploads'])
            ->findOrFail($id);

        return view('admin.plwds.show', compact('profile'));
    }

    /**
     * Approve a PLWD registration.
     */
    public function approve($id)
    {
        $profile = PlwdProfile::findOrFail($id);
        $profile->verified = true;
        $profile->save();

        AuditService::log(
            'PLWD Approved',
            "Approved PLWD profile for user: {$profile->user->name}",
            PlwdProfile::class,
            $profile->id
        );

        // Send email notification
        try {
            $profile->user->notify(new ProfileApproved($profile));
        } catch (\Exception $e) {
            // Log error but don't fail the approval
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'PLWD profile approved successfully!');
    }

    /**
     * Reject a PLWD registration.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $profile = PlwdProfile::findOrFail($id);
        $profile->verified = false;
        $profile->save();

        AuditService::log(
            'PLWD Rejected',
            "Rejected PLWD profile for user: {$profile->user->name}. Reason: " . ($request->reason ?? 'Not specified'),
            PlwdProfile::class,
            $profile->id
        );

        // Send email notification with reason
        try {
            $profile->user->notify(new ProfileRejected($profile, $request->reason));
        } catch (\Exception $e) {
            // Log error but don't fail the rejection
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'PLWD profile rejected.');
    }

    /**
     * Delete a PLWD profile.
     */
    public function destroy($id)
    {
        $profile = PlwdProfile::findOrFail($id);
        $userName = $profile->user->name;
        
        AuditService::log(
            'PLWD Deleted',
            "Deleted PLWD profile for user: {$userName}",
            PlwdProfile::class,
            $profile->id
        );

        $profile->user()->delete(); // This will cascade delete the profile

        return redirect()->route('admin.plwds.index')->with('success', 'PLWD profile deleted successfully!');
    }

    /**
     * Display reports page.
     */
    public function reports()
    {
        // Get statistics for reports
        $totalPlwds = PlwdProfile::count();
        $verifiedPlwds = PlwdProfile::where('verified', true)->count();
        $pendingPlwds = PlwdProfile::where('verified', false)->count();
        
        // PLWDs by disability type
        $plwdsByDisability = PlwdProfile::with('disabilityType')
            ->get()
            ->groupBy('disability_type_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->disabilityType->name ?? 'Unknown',
                    'count' => $group->count()
                ];
            })->sortByDesc('count');

        // PLWDs by education level
        $plwdsByEducation = PlwdProfile::with('educationLevel')
            ->get()
            ->groupBy('education_level_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->educationLevel->name ?? 'Unknown',
                    'count' => $group->count()
                ];
            })->sortByDesc('count');

        // PLWDs by gender
        $plwdsByGender = PlwdProfile::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->get();

        // PLWDs by state
        $plwdsByState = PlwdProfile::selectRaw('state, count(*) as count')
            ->whereNotNull('state')
            ->groupBy('state')
            ->orderBy('count', 'desc')
            ->get();

        // Recent registrations
        $recentRegistrations = PlwdProfile::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Monthly registration trends (last 12 months)
        $monthlyRegistrations = PlwdProfile::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports', compact(
            'totalPlwds',
            'verifiedPlwds',
            'pendingPlwds',
            'plwdsByDisability',
            'plwdsByEducation',
            'plwdsByGender',
            'plwdsByState',
            'recentRegistrations',
            'monthlyRegistrations'
        ));
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel(Request $request)
    {
        AuditService::log('Data Export', 'Exported PLWD data to Excel');

        return Excel::download(new PlwdExport($request->all()), 'plwds_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export data to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = PlwdProfile::with(['user', 'disabilityType', 'educationLevel']);

        // Apply same filters as listPlwds
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('disability_type')) {
            $query->where('disability_type_id', $request->disability_type);
        }

        $plwds = $query->get();

        AuditService::log('Data Export', 'Exported PLWD data to PDF');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('plwds'));
        return $pdf->download('plwds_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Display audit logs.
     */
    public function auditLogs()
    {
        $logs = AuditLog::with('admin')->latest()->paginate(50);

        return view('admin.audit-logs', compact('logs'));
    }

    /**
     * Manage disability types.
     */
    public function manageDisabilityTypes()
    {
        $disabilityTypes = DisabilityType::withCount('plwdProfiles')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.metadata.disability-types', compact('disabilityTypes'));
    }

    /**
     * Store a new disability type.
     */
    public function storeDisabilityType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:disability_types',
            'description' => 'nullable|string',
        ]);

        $disabilityType = DisabilityType::create($validated);

        AuditService::log(
            'Disability Type Created',
            "Created new disability type: {$disabilityType->name}",
            DisabilityType::class,
            $disabilityType->id
        );

        return redirect()->back()->with('success', 'Disability type created successfully!');
    }

    /**
     * Update a disability type.
     */
    public function updateDisabilityType(Request $request, $id)
    {
        $disabilityType = DisabilityType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:disability_types,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $oldName = $disabilityType->name;
        $disabilityType->update($validated);

        AuditService::log(
            'Disability Type Updated',
            "Updated disability type from '{$oldName}' to '{$disabilityType->name}'",
            DisabilityType::class,
            $disabilityType->id
        );

        return redirect()->back()->with('success', 'Disability type updated successfully!');
    }

    /**
     * Delete a disability type.
     */
    public function destroyDisabilityType($id)
    {
        $disabilityType = DisabilityType::findOrFail($id);

        // Check if any PLWDs are using this disability type
        if ($disabilityType->plwdProfiles()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete disability type that is assigned to PLWDs.');
        }

        $name = $disabilityType->name;
        $disabilityType->delete();

        AuditService::log(
            'Disability Type Deleted',
            "Deleted disability type: {$name}",
            DisabilityType::class,
            $id
        );

        return redirect()->back()->with('success', 'Disability type deleted successfully!');
    }

    /**
     * Manage education levels.
     */
    public function manageEducationLevels()
    {
        $educationLevels = EducationLevel::withCount('plwdProfiles')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.metadata.education-levels', compact('educationLevels'));
    }

    /**
     * Store a new education level.
     */
    public function storeEducationLevel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:education_levels',
            'description' => 'nullable|string',
        ]);

        $educationLevel = EducationLevel::create($validated);

        AuditService::log(
            'Education Level Created',
            "Created new education level: {$educationLevel->name}",
            EducationLevel::class,
            $educationLevel->id
        );

        return redirect()->back()->with('success', 'Education level created successfully!');
    }

    /**
     * Update an education level.
     */
    public function updateEducationLevel(Request $request, $id)
    {
        $educationLevel = EducationLevel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:education_levels,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $oldName = $educationLevel->name;
        $educationLevel->update($validated);

        AuditService::log(
            'Education Level Updated',
            "Updated education level from '{$oldName}' to '{$educationLevel->name}'",
            EducationLevel::class,
            $educationLevel->id
        );

        return redirect()->back()->with('success', 'Education level updated successfully!');
    }

    /**
     * Delete an education level.
     */
    public function destroyEducationLevel($id)
    {
        $educationLevel = EducationLevel::findOrFail($id);

        // Check if any PLWDs are using this education level
        if ($educationLevel->plwdProfiles()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete education level that is assigned to PLWDs.');
        }

        $name = $educationLevel->name;
        $educationLevel->delete();

        AuditService::log(
            'Education Level Deleted',
            "Deleted education level: {$name}",
            EducationLevel::class,
            $id
        );

        return redirect()->back()->with('success', 'Education level deleted successfully!');
    }

    /**
     * Manage skills.
     */
    public function manageSkills()
    {
        $skills = Skill::orderBy('name')->paginate(10);

        return view('admin.metadata.skills', compact('skills'));
    }

    /**
     * Store a new skill.
     */
    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'description' => 'nullable|string',
        ]);

        $skill = Skill::create($validated);

        AuditService::log(
            'Skill Created',
            "Created new skill: {$skill->name}",
            Skill::class,
            $skill->id
        );

        return redirect()->back()->with('success', 'Skill created successfully!');
    }

    /**
     * Update a skill.
     */
    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $oldName = $skill->name;
        $skill->update($validated);

        AuditService::log(
            'Skill Updated',
            "Updated skill from '{$oldName}' to '{$skill->name}'",
            Skill::class,
            $skill->id
        );

        return redirect()->back()->with('success', 'Skill updated successfully!');
    }

    /**
     * Delete a skill.
     */
    public function destroySkill($id)
    {
        $skill = Skill::findOrFail($id);

        $name = $skill->name;
        $skill->delete();

        AuditService::log(
            'Skill Deleted',
            "Deleted skill: {$name}",
            Skill::class,
            $id
        );

        return redirect()->back()->with('success', 'Skill deleted successfully!');
    }

    /**
     * Display settings page.
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'records_per_page' => 'nullable|integer|min:5|max:100',
        ]);

        // Here you would typically save settings to database or config
        // For now, we'll just redirect back with success message
        
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
}
