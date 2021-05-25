<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payer')->unsigned();
            $table->bigInteger('payee')->unsigned();
            $table->float('value');
            $table->enum('status',['pending','denied','complete'])->default('pending');
            $table->timestamps();

            $table->foreign('payer')
                ->references('id')
                ->on('wallets');

            $table->foreign('payee')
                ->references('id')
                ->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
