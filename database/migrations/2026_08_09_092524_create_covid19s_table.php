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
        Schema::create('covid19s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('date')->nullable();
            $table->string('country')->nullable();
            $table->integer('total')->nullable();
            $table->integer('active')->nullable();
            $table->integer('death')->nullable();
            $table->integer('recovered')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covid19s');
    }
};
