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
            $table->string('status')->default("PENDING");
            $table->text('description')->nullable();
            $table->decimal('bruto')->default("0");            
            $table->decimal('diskon')->default("0");
            $table->decimal('hdkp')->default("0");
            $table->decimal('tax')->default("0");
            $table->decimal('netto')->default("0");
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
