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
        Schema::create('menu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('kode', 8)->nullable();
            $table->string('url', 64)->default('#');
            $table->string('icon', 64)->nullable();
            $table->string('title', 64);
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });
        
        Schema::create('submenu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('kode', 12)->nullable();
            $table->string('url', 64)->default('#');
            $table->string('icon', 64)->nullable();
            $table->string('title', 64);
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->unsignedTinyInteger('menu_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('menu_id')
            ->references('id')->on('menu')
            ->onDelete('CASCADE');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submenu');
        Schema::dropIfExists('menu');
    }
};
