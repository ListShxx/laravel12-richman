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
            $table->renameColumn('a', 'total_in_1m');        //เปลี่ยนชื่อ COLUMN
            $table->text('remark')->nullable()->change();    //เปลื่ยน COLUMN TYPE
            $table->dropColumn('c');                         //ลบ column ทิ้ง

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
