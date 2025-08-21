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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('white_noise_id')->unique();
            $table->string('full_name');
            $table->string('photo_url');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('id_presented');
            $table->integer('id_number');
            $table->string('email');
            $table->string('phone_number');
            $table->enum('member_type', ['Student', 'Regular'])->default('Regular');
            $table->enum('membership_term_gym_access', ['None', '1 month', '3 months', 'Walk in'])->default('None');
            $table->enum('with_pt', ['None', '1 month'])->default('None');
            $table->date('pt_start_date')->nullable();
            $table->date('pt_end_date')->nullable();
            $table->date('membership_start_date');
            $table->date('membership_end_date');
            $table->date('gym_access_start_date')->nullable();
            $table->date('gym_access_end_date')->nullable();
            $table->integer('membership_term_billing_rate')->nullable();
            $table->integer('with_pt_billing_rate')->nullable();
            $table->string('emergency_contact_person');
            $table->string('emergency_contact_number');
            $table->integer('weight_kg');
            $table->integer('height_cm');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
