<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add missing indexes for query optimization
     */
    public function up(): void
    {
        // Opportunities table - frequently queried and filtered
        Schema::table('opportunities', function (Blueprint $table) {
            // Status is used in WHERE clauses for filtering active/inactive/expired
            $table->index('status');
            
            // Type is used for filtering by opportunity type (employment, training, etc.)
            $table->index('type');
            
            // Deadline is used for filtering expired opportunities
            $table->index('deadline');
            
            // Composite indexes for common query patterns
            $table->index(['status', 'created_at']); // Active opportunities sorted by date
            $table->index(['status', 'deadline']); // Active + not expired filtering
            $table->index(['type', 'status']); // Filter by type and active status
            
            // Views for sorting by popularity
            $table->index('views');
        });

        // Education Records table - queried for user profiles
        Schema::table('education_records', function (Blueprint $table) {
            // Frequently used for ordering by year
            $table->index('from_year');
            $table->index('to_year');
            
            // Composite index for profile queries
            $table->index(['plwd_profile_id', 'from_year']); // All records for a profile sorted by year
            
            // For timestamp-based sorting
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop opportunities indexes
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['type']);
            $table->dropIndex(['deadline']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['status', 'deadline']);
            $table->dropIndex(['type', 'status']);
            $table->dropIndex(['views']);
        });

        // Drop education_records indexes
        Schema::table('education_records', function (Blueprint $table) {
            $table->dropIndex(['from_year']);
            $table->dropIndex(['to_year']);
            $table->dropIndex(['plwd_profile_id', 'from_year']);
            $table->dropIndex(['created_at']);
        });
    }
};
