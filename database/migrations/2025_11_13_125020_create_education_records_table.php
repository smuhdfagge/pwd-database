<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('education_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plwd_profile_id')->constrained('plwd_profiles')->onDelete('cascade');
            $table->foreignId('education_level_id')->nullable()->constrained('education_levels')->onDelete('set null');
            $table->string('institution')->nullable();
            $table->year('from_year')->nullable();
            $table->year('to_year')->nullable();
            $table->string('certificate_obtained')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_records');
    }
};
