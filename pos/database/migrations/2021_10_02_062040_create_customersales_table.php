<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customersales', function (Blueprint $table) {
            $table->id();
            $table->String('name')->null();
            $table->String('phoneno')->null();
            $table->String('productQuantity');
            $table->String('billno');
            $table->String('amount');
            $table->String('discount');
            $table->String('journalno')->null();
            $table->String('cashier');
            $table->String('branch');
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
        Schema::dropIfExists('customersales');
    }
}
