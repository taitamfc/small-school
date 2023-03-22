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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->string('type')->default('yeu_cau_buoi_day');
            $table->float('fee')->default(0)->nullable();
            // Đề nghị thêm sinh viên mới
            $table->text('add_students')->nullable();
            // Đề nghị cho sinh viên hiện tại
            $table->text('student_ids')->nullable();
            
            // Thông tin về lịch dạy
            $table->string('event_name')->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->date('end_loop')->nullable();
            $table->boolean('recurrence')->default(0)->nullable();
            $table->text('recurrence_days')->nullable();
            $table->bigInteger('durration')->default(0);

            // Ghi chú của quản lý
            $table->string('status')->default('cho_xac_nhan');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
