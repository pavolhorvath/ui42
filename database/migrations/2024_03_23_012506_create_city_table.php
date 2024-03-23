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
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_district_id')->constrained('country_district')->onUpdate('cascade');
            $table->string('name', 255);
            $table->string('mayor_name', 255);
            $table->string('address', 255);
            $table->string('phone', 255);
            $table->string('fax', 255);
            $table->string('email', 255);
            $table->string('web', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};
