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
        Schema::create('sent_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('businessId')->references('id')->on('businesses')->default(0);
            // $table->foreignId('messageId')->references('id')->on('text_messages');
            $table->string('sendToType')->references('type')->on('send_to_types')->default("");
            $table->foreignId('textMessageId')->references('id')->on('text_messages')->default(0)->onDelete('cascade');
            $table->integer('timesSent')->default(0);
            // $table->
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
        Schema::dropIfExists('sent_messages');
    }
};
