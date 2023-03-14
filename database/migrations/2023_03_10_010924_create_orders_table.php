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
            $table->id();
            $table->integer('variant_id');
            $table->integer('user_id');
            $table->integer('seller_id');
            $table->string('customer_name', 50);
            $table->string('customer_address');
            $table->tinyInteger('qty')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('payment_method', 20);
            $table->integer('gross_amount');
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
