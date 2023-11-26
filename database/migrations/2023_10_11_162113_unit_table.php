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
        Schema::create('unit', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kode', 8)->nullable();
            $table->string('title', 64);
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('unit_has_pengguna', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedInteger('pengguna_id');
            $table->unsignedSmallInteger('unit_id');
            $table->timestamps();

            $table->foreign('pengguna_id')
            ->references('id')->on('pengguna')
            ->onDelete('CASCADE');

            $table->foreign('unit_id')
            ->references('id')->on('unit')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit');
        Schema::dropIfExists('unit_has_pengguna');
    }
};
