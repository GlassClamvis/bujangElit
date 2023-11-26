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
        Schema::create('berita', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->longText('content');
            $table->string('cover')->nullable();
            $table->string('url');
            $table->unsignedSmallInteger('viewer')->nullable();
            $table->unsignedTinyInteger('read_time')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('is_aktif')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('berita');
    }
};
