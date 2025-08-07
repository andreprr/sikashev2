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
        Schema::create('form_input_details', function (Blueprint $table) {
            $table->id();
            $table->integer('form_input_id')->nullable();
            $table->integer('step_id')->nullable();
            $table->string('field_name');
            $table->string('field_label');
            $table->text('field_description')->nullable();
            $table->enum('field_type',['file','text','textarea','date','select']);
            $table->enum('allowed_type',['png','jpg','pdf','any'])->nullable();
            $table->string('default_value')->nullable();
            $table->string('model_referer')->nullable();
            $table->boolean('need_verif')->nullable();
            $table->boolean('is_required')->nullable();
            $table->integer('field_order')->nullable();
            $table->text('options')->nullable();
            $table->text('value')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('isValid')->nullable();
            $table->datetime('valid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_input_details');
    }
};
