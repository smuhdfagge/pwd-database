<?php

namespace App\Exports;

use App\Models\PlwdProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlwdExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = PlwdProfile::with(['user', 'disabilityType', 'educationLevel']);

        // Apply filters
        if (!empty($this->filters['state'])) {
            $query->where('state', $this->filters['state']);
        }

        if (!empty($this->filters['disability_type'])) {
            $query->where('disability_type_id', $this->filters['disability_type']);
        }

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['verified'])) {
            $query->where('verified', $this->filters['verified']);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Gender',
            'Date of Birth',
            'Age',
            'Phone',
            'Address',
            'State',
            'LGA',
            'Disability Type',
            'Education Level',
            'Skills',
            'Verified',
            'Registration Date',
        ];
    }

    /**
     * @param mixed $profile
     * @return array
     */
    public function map($profile): array
    {
        return [
            $profile->id,
            $profile->user->name,
            $profile->user->email,
            $profile->gender,
            $profile->date_of_birth?->format('Y-m-d'),
            $profile->age,
            $profile->phone,
            $profile->address,
            $profile->state,
            $profile->lga,
            $profile->disabilityType?->name,
            $profile->educationLevel?->name,
            is_array($profile->skills) ? implode(', ', $profile->skills) : '',
            $profile->verified ? 'Yes' : 'No',
            $profile->created_at->format('Y-m-d'),
        ];
    }
}
