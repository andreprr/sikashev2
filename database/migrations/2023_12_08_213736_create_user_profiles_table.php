<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nik')->nullable();
            $table->string('nip')->nullable();
            $table->enum('gender',array('Laki-laki','Perempuan'))->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('satker')->nullable();
            $table->string('instansi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('img_url')->default('userdefault.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
