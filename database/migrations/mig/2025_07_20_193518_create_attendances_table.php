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
        Schema::create("attend", function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained()->onDelete("cascade");
            $table->dateTime("check_in_time");
            $table->dateTime("check_out_time")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("attendances");
    }
};


