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
        Schema::table('users', function (Blueprint $table) {
            $table->string('skills')->nullable()->after('profile_image');
            $table->string('documents')->nullable()->after('skills');
            $table->string('resume')->nullable()->after('documents');
            $table->string('contract')->nullable()->after('resume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['skills', 'documents', 'resume', 'contract']);
        });
    }
};
