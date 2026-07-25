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
        Schema::table('inbound_groups', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('first_time')->nullable();
            $table->string('last_time')->nullable();
            $table->string('cutoff_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inbound_groups', function (Blueprint $table) {
            //
        });
    }
};
