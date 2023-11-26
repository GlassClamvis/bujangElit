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
        Schema::create('jenis_media_properties', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('urut')->default(NULL);
            $table->string('title', 64);
            $table->unsignedTinyInteger('is_aktif')->default(1);
            $table->unsignedTinyInteger('jenis_media_id');
            $table->timestamps();
            
            $table->foreign('jenis_media_id')
            ->references('id')->on('jenis_media')
            ->onDelete('CASCADE');
        });
        
        Schema::create('media_data', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedBigInteger('media_id');
            $table->unsignedTinyInteger('jenis_media_properties_id');
            $table->string('file',64);
            $table->timestamps();

            $table->foreign('jenis_media_properties_id')
            ->references('id')->on('jenis_media_properties')
            ->onDelete('CASCADE');

            $table->foreign('media_id')
            ->references('id')->on('media')
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
        Schema::dropIfExists('media_data');
        Schema::dropIfExists('jenis_media_properties');
    }
};
