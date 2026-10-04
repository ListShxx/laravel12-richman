<?php

// database/migrations/xxxx_add_leave_fields_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee'); // กำหนดสิทธิ์ 'employee' หรือ 'manager'
            $table->integer('remaining_leave_days')->default(15); // กำหนดวันลาคงเหลือเริ่มต้น
        });
    }
};

// database/migrations/xxxx_create_leave_requests_table.php
return new class extends Migration {
    public function up(): void {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }
};