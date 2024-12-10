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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('is_admin')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('auth_type')->nullable();
            $table->text('auth_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyText('refer_code')->nullable();
            $table->text('skill_list')->nullable();
            $table->text('category_list')->nullable();
            $table->string('address')->nullable();
            $table->text('location_list')->nullable();
            $table->mediumText('about')->nullable();
            $table->unsignedDecimal('price', $precision = 10, $scale = 2)->nullable();
            $table->string('places_id')->nullable();
            $table->string('expertise_label')->nullable();
            $table->string('contact', 30)->nullable();
            $table->text('insurance_img')->nullable();
            $table->text('avatar')->nullable();
            $table->tinyInteger('client_location')->nullable();
            $table->string('fcm_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
