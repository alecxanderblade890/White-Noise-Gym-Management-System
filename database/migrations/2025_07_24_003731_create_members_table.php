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
            $table->string('name');
            $table->string('photo_url');
            $table->date('payment_date_membership');
            $table->integer('membership_term_gym_access');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('billing_rate');
            $table->date('payment_date_gym_access');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('id_presented');
            $table->integer('id_number');
            $table->string('email');
            $table->string('phone_number');
            $table->string('contact_person');
            $table->string('emergency_contact_number');
            $table->integer('weight_kg');
            $table->integer('height_cm');
            $table->text('notes');
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
