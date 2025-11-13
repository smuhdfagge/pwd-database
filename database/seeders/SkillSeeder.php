<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Computer Literacy', 'description' => 'Basic computer skills'],
            ['name' => 'Data Entry', 'description' => 'Data entry and management'],
            ['name' => 'Customer Service', 'description' => 'Customer service and support'],
            ['name' => 'Graphic Design', 'description' => 'Visual design and graphics'],
            ['name' => 'Web Development', 'description' => 'Website development'],
            ['name' => 'Accounting', 'description' => 'Financial management'],
            ['name' => 'Tailoring/Sewing', 'description' => 'Garment making'],
            ['name' => 'Carpentry', 'description' => 'Woodworking'],
            ['name' => 'Electrical Work', 'description' => 'Electrical installations'],
            ['name' => 'Plumbing', 'description' => 'Plumbing installations'],
            ['name' => 'Welding', 'description' => 'Metal welding'],
            ['name' => 'Farming/Agriculture', 'description' => 'Agricultural activities'],
            ['name' => 'Teaching', 'description' => 'Education and training'],
            ['name' => 'Hairdressing/Barbing', 'description' => 'Hair styling'],
            ['name' => 'Catering/Cooking', 'description' => 'Food preparation'],
            ['name' => 'Photography', 'description' => 'Photography services'],
            ['name' => 'Content Writing', 'description' => 'Writing and editing'],
            ['name' => 'Marketing', 'description' => 'Sales and marketing'],
            ['name' => 'Music/Arts', 'description' => 'Creative arts'],
            ['name' => 'Others', 'description' => 'Other skills'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
