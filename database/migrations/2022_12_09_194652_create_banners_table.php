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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->boolean('active')->default(false);
            $table->integer('position');
            $table->longText('content')->default("<p>Hello World</p>");
            $table->string('type')->nullable();
            $table->timestamp('start-data')->nullable();
            $table->timestamp('end-data')->nullable();
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
        Schema::dropIfExists('banners');
    }
};
