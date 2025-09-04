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
            $table->time('time_out')->nullable();
            $table->string('white_noise_id')->nullable();
            $table->foreign('white_noise_id')
                  ->references('white_noise_id')
                  ->on('members')
                  ->onDelete('set null');
            $table->string('full_name');
            $table->enum('payment_method', ['None', 'Cash', 'GCash', 'Bank Transfer']);
            $table->unsignedInteger('payment_amount');
            $table->enum('member_type', ['Regular', 'Student']);
            $table->enum('gym_access', ['None', '1 month', '3 months', 'Walk in']);
            $table->enum('personal_trainer', ['None', '1 month']);
            $table->json('items_bought')->nullable();
            $table->json('purpose_of_visit');
            $table->string('staff_assigned');
            $table->boolean('upgrade_gym_access'); 
            $table->text('notes')->nullable(); 
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
