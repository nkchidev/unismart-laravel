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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->string('ship_address');
            $table->integer('num_order');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['processing', 'pending', 'completed', 'cancelled']);
            $table->string('payment_method');
            $table->text('note')->nullable();
            $table->timestamps();
            
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
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
};
