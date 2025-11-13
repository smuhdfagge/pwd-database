<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add performance indexes to support concurrent user access
     */
    public function up(): void
    {
        // Users table - frequently queried by role and status
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('status');
            $table->index(['role', 'status']); // Composite index for combined queries
            $table->index('created_at');
        });

        // PLWD Profiles table - heavily queried with filters
        Schema::table('plwd_profiles', function (Blueprint $table) {
            // Frequently used in WHERE clauses
            $table->index('verified');
            $table->index('state');
            $table->index('gender');
            
            // Composite indexes for common filter combinations
            $table->index(['verified', 'state']);
            $table->index(['verified', 'disability_type_id']);
            $table->index(['verified', 'gender']);
            $table->index(['state', 'disability_type_id']);
            
            // For sorting and pagination
            $table->index('created_at');
            $table->index('updated_at');
            
            // Geospatial queries (if using location-based searches)
            $table->index(['latitude', 'longitude']);
        });

        // Uploads table - queried by type and plwd_id
        Schema::table('uploads', function (Blueprint $table) {
            $table->index('type');
            $table->index(['plwd_id', 'type']); // Composite for filtering uploads by user and type
            $table->index('created_at');
        });

        // Audit Logs table - frequently queried by admin actions and date
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->index('action');
            $table->index('model_type');
            $table->index(['model_type', 'model_id']); // For polymorphic queries
            $table->index(['admin_id', 'created_at']); // Admin activity tracking
            $table->index('created_at'); // Time-based queries
        });

        // Disability Types table - for quick lookups
        Schema::table('disability_types', function (Blueprint $table) {
            $table->index('name');
        });

        // Education Levels table - for quick lookups
        Schema::table('education_levels', function (Blueprint $table) {
            $table->index('name');
        });

        // Skills table - for quick lookups
        Schema::table('skills', function (Blueprint $table) {
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes in reverse order
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('plwd_profiles', function (Blueprint $table) {
            $table->dropIndex(['verified']);
            $table->dropIndex(['state']);
            $table->dropIndex(['gender']);
            $table->dropIndex(['verified', 'state']);
            $table->dropIndex(['verified', 'disability_type_id']);
            $table->dropIndex(['verified', 'gender']);
            $table->dropIndex(['state', 'disability_type_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['latitude', 'longitude']);
        });

        Schema::table('uploads', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['plwd_id', 'type']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex(['action']);
            $table->dropIndex(['model_type']);
            $table->dropIndex(['model_type', 'model_id']);
            $table->dropIndex(['admin_id', 'created_at']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('disability_types', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('education_levels', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
