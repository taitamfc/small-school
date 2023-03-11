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
        Schema::table('events', function (Blueprint $table) {
            $table->string('status')->default('cho_thuc_hien');
            $table->float('fee')->default(0);
            $table->text('proof')->nullable();
            $table->bigInteger('durration')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('fee');
            $table->dropColumn('proof');
            $table->dropColumn('durration');
        });
    }
};
