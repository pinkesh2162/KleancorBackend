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
        Schema::create('house_keeping_radios', function (Blueprint $table) {
            $table->id();
            $table->string('posting_title', 100)->nullable();
            $table->string('display_title', 100)->nullable();
            $table->text('label_list')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('serial')->default(1);
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
        Schema::dropIfExists('house_keeping_radios');
    }
};
