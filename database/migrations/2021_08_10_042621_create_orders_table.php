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
            $table->foreignId('branch_id')->references('id')->on('branches');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('code')->unique();
            $table->string('status')->default("DRAFT");
            $table->text('description')->nullable();
            $table->decimal('subtotal',15,2)->default("0");            
            $table->decimal('diskon',5,2)->default("0");
            $table->decimal('diskon_value',13,2)->default("0");
            $table->decimal('hdkp',13,2)->default("0");
            $table->decimal('tax',13,2)->default("0");
            $table->decimal('total',13,2)->default("0");
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
