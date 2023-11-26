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
        Schema::create('kategori', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('label');
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->timestamps();
        });

        Schema::table('berita', function ($table) {
            $table->unsignedSmallInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id')->on('kategori')
                ->onDelete('SET NULL');
        });
        
        Schema::table('media', function ($table) {
            $table->unsignedSmallInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id')->on('kategori')
                ->onDelete('SET NULL');
        });

        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('berita_id');
            $table->unsignedSmallInteger('kategori_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL');

            $table->foreign('berita_id')
                ->references('id')->on('berita')
                ->onDelete('CASCADE');

            $table->foreign('kategori_id')
                ->references('id')->on('kategori')
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
        Schema::dropIfExists('kategori_berita');

        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn('kategori_id');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('media_id');
        });

        Schema::dropIfExists('kategori');
    }
};
