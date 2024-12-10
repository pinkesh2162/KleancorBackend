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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('locations_id')->constrained('locations'); 
            $table->string('address')->nullable();
            $table->string('project_name')->nullable();
            $table->tinyInteger('job_type')->nullable();
            $table->unsignedDecimal('price', $precision = 10, $scale = 2)->nullable();
            $table->unsignedDecimal('final_price', $precision = 10, $scale = 2)->nullable();
            $table->unsignedDecimal('total_amount', $precision = 10, $scale = 2)->nullable();
            $table->smallInteger('categories_id')->nullable();         
            $table->smallInteger('number_of_worker')->nullable();
            $table->smallInteger('hours')->nullable();            
            $table->smallInteger('final_hour')->nullable();            
            $table->tinyInteger('week_type')->nullable();
            $table->dateTime('dead_line')->nullable();
            $table->longText('house_keeping_list')->nullable();
            $table->longText('house_keeping_radio_list')->nullable();
            $table->text('skill_list')->nullable();
            $table->tinyText('contact')->nullable();
            $table->smallInteger('awards_id')->nullable();
            $table->foreignId('poster_id')->constrained('users');
            $table->tinyInteger('house_type')->default(1);
            $table->tinyInteger('main_entry')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('client_recommended')->default(0);
            $table->tinyInteger('client_rating1')->default(0);
            $table->tinyInteger('client_rating2')->default(0);
            $table->tinyInteger('client_rating3')->default(0);
            $table->string('client_comment', 255)->nullable();
            $table->tinyInteger('worker_rating1')->default(0);
            $table->tinyInteger('worker_rating2')->default(0);
            $table->tinyInteger('worker_rating3')->default(0);
            $table->string('worker_comment', 255)->nullable();
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
        Schema::dropIfExists('jobs');
    }
};
