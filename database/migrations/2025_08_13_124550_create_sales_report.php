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
        Schema::create('sales_report', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('memberships_only')->default(0);
            $table->integer('walk_in_regular_on_sign_up')->default(0);
            $table->integer('walk_in_student_on_sign_up')->default(0);
            $table->integer('personal_trainer_on_sign_up')->default(0);
            $table->integer('1_month_regular')->default(0);
            $table->integer('1_month_student')->default(0);
            $table->integer('3_months_regular')->default(0);
            $table->integer('3_months_student')->default(0);
            $table->integer('walk_in_regular')->default(0);
            $table->integer('walk_in_student')->default(0);
            $table->integer('gym_access_1_month_regular')->default(0);
            $table->integer('gym_access_1_month_student')->default(0);
            $table->integer('gym_access_3_months_regular')->default(0);
            $table->integer('gym_access_3_months_student')->default(0);
            $table->integer('personal_trainer_1_month')->default(0);
            $table->integer('personal_trainer_walk_in')->default(0);
            $table->integer('total_sales')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_report');
    }
};
