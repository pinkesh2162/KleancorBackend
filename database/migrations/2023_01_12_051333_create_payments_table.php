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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('client_id')->nullable();
            $table->tinyInteger('worker_id')->nullable();
            $table->tinyInteger('job_category_id')->nullable();
            $table->double('amount', 6, 2)->nullable();
            $table->string('invoice_number', 30)->nullable();
            $table->date('payment_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->smallInteger('total_hour')->default(1);
            $table->date('last_update')->nullable();          
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
        Schema::dropIfExists('payments');
    }
};
