<?php

namespace Database\Seeders;

use App\Models\DisabilityType;
use Illuminate\Database\Seeder;

class DisabilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disabilityTypes = [
            [
                'name' => 'Visual Impairment',
                'description' => 'Partial or complete loss of vision',
            ],
            [
                'name' => 'Hearing Impairment',
                'description' => 'Partial or complete loss of hearing',
            ],
            [
                'name' => 'Physical/Mobility Impairment',
                'description' => 'Limitations in physical mobility or motor skills',
            ],
            [
                'name' => 'Speech and Language Impairment',
                'description' => 'Difficulties in speech production or language understanding',
            ],
            [
                'name' => 'Intellectual Disability',
                'description' => 'Limitations in intellectual functioning and adaptive behavior',
            ],
            [
                'name' => 'Mental Health Condition',
                'description' => 'Psychological or psychiatric conditions affecting daily functioning',
            ],
            [
                'name' => 'Learning Disability',
                'description' => 'Difficulties in learning and processing information',
            ],
            [
                'name' => 'Autism Spectrum Disorder',
                'description' => 'Developmental condition affecting communication and behavior',
            ],
            [
                'name' => 'Multiple Disabilities',
                'description' => 'Combination of two or more disability types',
            ],
        ];

        foreach ($disabilityTypes as $type) {
            DisabilityType::create($type);
        }
    }
}
