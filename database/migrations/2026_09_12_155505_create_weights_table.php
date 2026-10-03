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
        Schema::create('weights', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_on'); // คอลัมน์ที่เราเพิ่มเข้าไปก่อนหน้านี้
            $table->float('weight');
            $table->foreignId('user_id')->nullable();
            // $table->timestamps(); 
        }); // <-- จุดที่มักจะลืม คือต้องมี }); ปิดท้ายตรงนี้ครับ
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weights');
    }
};
