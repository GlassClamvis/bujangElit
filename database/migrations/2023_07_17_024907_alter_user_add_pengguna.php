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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('foto');
            $table->unsignedTinyInteger('is_aktif');
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->unsignedTinyInteger('is_aktif');
            $table->unsignedInteger('pengguna_id');

            $table->foreign('pengguna_id')
                ->references('id')->on('pengguna')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_aktif');
            $table->dropColumn('pengguna_id');
        });
        Schema::dropIfExists('pengguna');
    }
};
