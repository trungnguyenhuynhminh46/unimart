<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema1: Tạo bảng product_cats
        Schema::create('product_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1000);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });
        // Schema2: Tạo FK
        Schema::table('product_cats', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('product_cats')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_cats');
    }
}
