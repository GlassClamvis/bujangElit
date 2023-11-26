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
        Schema::create('jenis_media', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('label');
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('tag', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('label');
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('penerbit', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('label');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->string('email');
            $table->string('logo');
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('jenis_media_id');
            $table->string('judul');
            $table->string('Deskripsi');
            $table->string('cover');
            $table->string('url');
            $table->string('isbn');
            $table->string('issn_cetak');
            $table->string('issn_daring');
            $table->string('abstrak');
            $table->unsignedSmallInteger('penerbit_id')->nullable();
            $table->year('tahun_terbit');
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->unsignedSmallInteger('viewer')->default(0);
            $table->unsignedSmallInteger('plagiarism_score')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL');

            $table->foreign('penerbit_id')
                ->references('id')->on('penerbit')
                ->onDelete('SET NULL');

            $table->foreign('jenis_media_id')
                ->references('id')->on('jenis_media')
                ->onDelete('CASCADE');
        });

        Schema::create('pengarang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('media_id');
            $table->string('nama');
            $table->unsignedTinyInteger('penulis_ke');
            $table->timestamps();

            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('CASCADE');
        });

        Schema::create('rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedTinyInteger('rating');
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL');

            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('CASCADE');
        });

        Schema::create('bookmark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');

            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('CASCADE');
        });

        Schema::create('tag_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedSmallInteger('tag_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL');

            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('CASCADE');

            $table->foreign('tag_id')
                ->references('id')->on('tag')
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
        Schema::dropIfExists('tag_media');
        Schema::dropIfExists('bookmark');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('pengarang');
        Schema::dropIfExists('media');
        Schema::dropIfExists('penerbit');
        Schema::dropIfExists('tag');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('jenis_media');
    }
};
