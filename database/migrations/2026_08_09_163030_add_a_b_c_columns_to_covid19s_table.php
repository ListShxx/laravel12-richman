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
        Schema::table('covid19s', function (Blueprint $table) {
            $table->double('a')->nullable();          //เพิ่มคอลัมน์ใหม่ type double, null ได้
            $table->double('remark')->nullable();     //เพิ่มคอลัมน์ใหม่ type double, null ได้
            $table->double('c')->nullable();          //เพิ่มคอลัมน์ใหม่ type double, null ได้

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('covid19s', function (Blueprint $table) {
            //
        });
    }
};
