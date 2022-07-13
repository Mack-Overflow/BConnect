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
        Schema::create('send_to_types', function (Blueprint $table) {
            $table->id();
            // For custom-created send to categories unique to each business
            // $table->foreignId('businessId')->references('id')->on('businesses')->default(0);
            $table->string('type')->unique();
            $table->text('description');
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
        Schema::dropIfExists('send_to_types');
    }
};
