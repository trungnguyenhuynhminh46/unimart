<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 10)->primary()->default('0000000000');
            $table->string('username')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('address', 1000);
            $table->string('phone_number');
            $table->text('note')->nullable();
            $table->string('payment')->default('cod');
            $table->string('status')->default('waiting');
            $table->unsignedBigInteger('total');
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
        Schema::dropIfExists('orders');
    }
}
