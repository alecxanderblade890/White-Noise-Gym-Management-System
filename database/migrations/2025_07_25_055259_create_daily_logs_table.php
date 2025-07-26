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
            $table->unsignedBigInteger('member_id'); // Assuming member_id is a foreign key
            $table->string('full_name');
            $table->unsignedInteger('membership_term_gym_access'); // Assuming this is a number
            $table->string('payment_method');
            $table->string('purpose_of_visit');
            $table->string('staff_assigned'); // Assuming staff assigned is a string
            $table->boolean('upgrade_gym_access'); // Assuming upgrade is a boolean
            $table->text('notes'); // Assuming notes is a text field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_log');
    }
};
