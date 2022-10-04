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
            $table->unsignedBigInteger('businessId');
            $table->foreignId('businessId')->references('id')->on('businesses')->default(1);
            $table->date('visitDate');
            $table->tinyInteger('numVisits')->default(0);
            $table->tinyInteger('urlClickedPurchased')->default(0);
            $table->foreignId('lastMsgSentType')->references('type')->on('send_to_types');
            $table->integer('messagesReceived')->default(0);
            $table->boolean('subscribed')->default(false);
            $table->timestamp('subscribed_at')->default(null)->nullable();
            $table->timestamp('unsubscribed_at')->default(null)->nullable();
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
        Schema::dropIfExists('subscribers');
    }
};
