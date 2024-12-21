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
        Schema::table('users', function (Blueprint $table) {
            $table->after('refer_code', function (Blueprint $table) {
				$table->string('official_id')->nullable();
				$table->date('dob')->nullable();
				$table->string('gender')->nullable();
				$table->text('social_media_links')->nullable();
			});
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['official_id', 'dob', 'gender', 'social_media_links']);
        });
    }
};
