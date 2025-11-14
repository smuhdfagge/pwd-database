<?php

namespace Tests\Unit;

use App\Models\PlwdProfile;
use App\Models\User;
use App\Models\DisabilityType;
use App\Models\EducationLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlwdProfileCompletionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test profile completion calculation with no fields filled.
     */
    public function test_profile_completion_with_no_fields(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => null,
            'date_of_birth' => null,
            'phone' => null,
            'address' => null,
            'state' => null,
            'lga' => null,
            'disability_type_id' => null,
            'education_level_id' => null,
            'skills' => null,
            'bio' => null,
            'photo' => null,
        ]);

        $this->assertEquals(0.0, $profile->profile_completion);
        $this->assertEquals(0, $profile->completed_required_fields);
        $this->assertEquals(8, $profile->total_required_fields);
        $this->assertFalse($profile->is_complete);
    }

    /**
     * Test profile completion with all required fields filled.
     */
    public function test_profile_completion_with_required_fields_only(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'phone' => '08012345678',
            'address' => 'Test Address',
            'state' => 'Lagos',
            'lga' => 'Ikeja',
            'disability_type_id' => 1,
            'education_level_id' => 1,
            'skills' => null,
            'bio' => null,
            'photo' => null,
        ]);

        $this->assertEquals(72.7, $profile->profile_completion);
        $this->assertEquals(8, $profile->completed_required_fields);
        $this->assertTrue($profile->is_complete);
    }

    /**
     * Test profile completion with all fields filled.
     */
    public function test_profile_completion_with_all_fields(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'phone' => '08012345678',
            'address' => 'Test Address',
            'state' => 'Lagos',
            'lga' => 'Ikeja',
            'disability_type_id' => 1,
            'education_level_id' => 1,
            'skills' => ['Programming', 'Web Design'],
            'bio' => 'This is a test bio',
            'photo' => 'photos/test.jpg',
        ]);

        $this->assertEquals(100.0, $profile->profile_completion);
        $this->assertEquals(8, $profile->completed_required_fields);
        $this->assertTrue($profile->is_complete);
    }

    /**
     * Test profile completion with some fields filled.
     */
    public function test_profile_completion_with_partial_fields(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => 'Female',
            'date_of_birth' => '1995-06-15',
            'phone' => '08098765432',
            'address' => null,
            'state' => 'Abuja',
            'lga' => null,
            'disability_type_id' => 1,
            'education_level_id' => null,
            'skills' => ['Teaching'],
            'bio' => null,
            'photo' => null,
        ]);

        // 5 required fields + 1 optional field = 6 out of 11 total
        $this->assertEquals(54.5, $profile->profile_completion);
        $this->assertEquals(5, $profile->completed_required_fields);
        $this->assertFalse($profile->is_complete);
    }

    /**
     * Test missing required fields attribute.
     */
    public function test_missing_required_fields(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => 'Male',
            'date_of_birth' => null,
            'phone' => '08012345678',
            'address' => null,
            'state' => 'Lagos',
            'lga' => 'Ikeja',
            'disability_type_id' => null,
            'education_level_id' => 1,
        ]);

        $missingFields = $profile->missing_required_fields;
        
        $this->assertContains('Date of Birth', $missingFields);
        $this->assertContains('Address', $missingFields);
        $this->assertContains('Disability Type', $missingFields);
        $this->assertCount(3, $missingFields);
    }

    /**
     * Test missing optional fields attribute.
     */
    public function test_missing_optional_fields(): void
    {
        $profile = PlwdProfile::factory()->make([
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'phone' => '08012345678',
            'address' => 'Test Address',
            'state' => 'Lagos',
            'lga' => 'Ikeja',
            'disability_type_id' => 1,
            'education_level_id' => 1,
            'skills' => null,
            'bio' => 'Test bio',
            'photo' => null,
        ]);

        $missingOptional = $profile->missing_optional_fields;
        
        $this->assertContains('Skills', $missingOptional);
        $this->assertContains('Profile Photo', $missingOptional);
        $this->assertNotContains('Personal Bio', $missingOptional);
        $this->assertCount(2, $missingOptional);
    }

    /**
     * Test skills array handling.
     */
    public function test_skills_array_handling(): void
    {
        // Empty array should not count as filled
        $profile1 = PlwdProfile::factory()->make(['skills' => []]);
        $this->assertContains('Skills', $profile1->missing_optional_fields);

        // Non-empty array should count as filled
        $profile2 = PlwdProfile::factory()->make(['skills' => ['Programming']]);
        $this->assertNotContains('Skills', $profile2->missing_optional_fields);
    }
}
