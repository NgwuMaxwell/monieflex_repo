<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('carousel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('animation_type')->default('slide');
            $table->string('direction')->default('left');
            $table->integer('display_duration')->default(5);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carousel_settings');
    }
}