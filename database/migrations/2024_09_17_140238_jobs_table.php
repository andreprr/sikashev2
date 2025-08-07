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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job');
            $table->string('description')->nullable();
            $table->string('opd')->nullable();
            $table->enum('type',['perguruan_tinggi','sekolah']);
            $table->enum('status',['draft','publish','finish'])->default('draft');
            $table->datetime('start_at')->nullable();
            $table->datetime('finish_at')->nullable();
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'jobs');
    }
};
