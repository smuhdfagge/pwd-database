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
        Schema::create('plwd_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->foreignId('disability_type_id')->nullable()->constrained('disability_types')->onDelete('set null');
            $table->foreignId('education_level_id')->nullable()->constrained('education_levels')->onDelete('set null');
            $table->json('skills')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('photo')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plwd_profiles');
    }
};
