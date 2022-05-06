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
        Schema::create('product', function (Blueprint $table) {
            $table->string('unique_key')->primary()->unique();
            $table->string('product_title');
            $table->text('product_description');
            $table->string('style#');
            $table->string('sanmar_mainframe_color');
            $table->string('size');
            $table->string('color_name');
            $table->double('piece_price');
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
        Schema::dropIfExists('product');
    }
};
