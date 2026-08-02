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
        Schema::create('inbound_cyrcles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbound_slot_id')->constrained('inbound_slots')->onDelete('cascade');
            $table->unsignedBigInteger('ib_group_id');
            $table->foreign('ib_group_id')->references('id')->on('inbound_groups')->ondelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_cyrcles');
    }
};
