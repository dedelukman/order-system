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
            $table->foreignId('branch_id');
            $table->foreignId('user_id');
            $table->string('code')->unique();
            $table->string('status');
            $table->text('description');
            $table->decimal('bruto');            
            $table->decimal('diskon');
            $table->decimal('hdkp');
            $table->decimal('tax');
            $table->decimal('netto');
            $table->softDeletes();
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
