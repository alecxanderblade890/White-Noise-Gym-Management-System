<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('id_number')->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->json('payment_history')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->integer('id_number')->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->dropColumn('payment_history');
        });
    }
};
