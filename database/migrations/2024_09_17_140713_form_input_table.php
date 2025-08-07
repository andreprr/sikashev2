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
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('uniq_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('submit_id')->nullable();
            $table->integer('form_input_id_before')->nullable();
            $table->integer('current_step')->nullable();
            $table->enum('status',['progress','success','fail'])->default('progress');
            $table->datetime('current_step_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists(table: 'form_inputs');
    }
};
