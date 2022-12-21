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
        Schema::table('banners', function (Blueprint $table){
           $table->date('start-date')->nullable();
           $table->date('end-date')->nullable();
           $table->dropColumn('end-data');
           $table->dropColumn('start-data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table){
            $table->dropColumn('start-date');
            $table->dropColumn('end-date');
            $table->timestamp('end-data')->nullable();
            $table->timestamp('start-data')->nullable();
        });
    }
};
