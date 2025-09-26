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
            $table->enum('tier', ['New Born', 'Tier 1', 'Tier 2', 'Tier 3'])->default('New Born');
            $table->enum('role', ['Administrator', 'Management', 'Admin Officer', 'User', 'Client'])->default('User');
            $table->date('start_work')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tier', 'role', 'start_work', 'birthday', 'status']);
        });
    }
};
