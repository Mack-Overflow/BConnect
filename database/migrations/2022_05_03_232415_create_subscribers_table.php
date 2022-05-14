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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName', 255)->nullable()->index('firstName');
            $table->string('lastName', 255)->nullable()->index('lastName');
            $table->string('phoneNumber', 255)->index('phoneNumber')->unique();
            $table->date('visitDate');
            $table->tinyInteger('numVisits')->default(0);
            $table->tinyInteger('urlClickedPurchased')->default(0);
            $table->integer('messagesReceived')->default(0);
            $table->boolean('subscribed')->default(false);
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
        Schema::dropIfExists('subscriber');
    }
};
