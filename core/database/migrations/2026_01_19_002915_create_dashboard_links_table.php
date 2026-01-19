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
        Schema::create('dashboard_links', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('url', 500);
            $table->string('icon', 255)->nullable();
            $table->enum('type', ['service', 'contact'])->default('service');
            $table->boolean('status')->default(1);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('dashboard_links');
    }
};
