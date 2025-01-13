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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('notification_type_id')->nullable()->after('status'); // Add foreign key column
            $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('set null'); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['notification_type_id']); // Drop foreign key constraint
            $table->dropColumn('notification_type_id'); // Drop column
        });
    }
};
