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
        Schema::table('teachers', function (Blueprint $table) {
            $table->text('level')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->string('image')->nullable();
            $table->string('cmnd')->nullable();
            $table->text('ho_khau')->nullable();
            $table->text('address')->nullable();
            $table->string('bank_user_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('recurrence_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
