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
        Schema::create('event_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->string('event_step');
            $table->string('step_owner');
            $table->text('step_description')->nullable();
            $table->integer('step_order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'event_steps');
    }
};
