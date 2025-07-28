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
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->time('time_in');
            $table->time('time_out');
            $table->foreignId('member_id')->constrained();
            $table->string('full_name');
            $table->integer('membership_term_gym_access');
            $table->string('payment_method');
            $table->unsignedInteger('payment_amount');
            $table->string('purpose_of_visit');
            $table->string('staff_assigned');
            $table->boolean('upgrade_gym_access'); 
            $table->text('notes'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
