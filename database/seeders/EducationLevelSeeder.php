<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationLevels = [
            'No Formal Education',
            'Primary Education',
            'Junior Secondary Education',
            'Senior Secondary Education',
            'Vocational/Technical Training',
            'National Diploma (ND)',
            'Higher National Diploma (HND)',
            'Bachelor\'s Degree',
            'Master\'s Degree',
            'Doctoral Degree',
        ];

        foreach ($educationLevels as $level) {
            EducationLevel::create(['name' => $level]);
        }
    }
}
