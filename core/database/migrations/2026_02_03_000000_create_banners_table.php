<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(1);
            
            // Carousel settings (global per banner set)
            $table->enum('animation_type', ['slide', 'fade'])->default('slide');
            $table->enum('slide_direction', ['left', 'right', 'up', 'down'])->default('left');
            $table->integer('display_duration')->default(5); // seconds
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
