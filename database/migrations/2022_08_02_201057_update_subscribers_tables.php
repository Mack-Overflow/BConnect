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
        Schema::table('subscribers', function ($table) {
            $table->timestamp('subscribed_at')->default(null)->nullable();
            $table->timestamp('unsubscribed_at')->default(null)->nullable();
            // $table->integer('googleReviewLinksClicked')->default(0);
            // $table->string('lastMsgSentType')->change();
            // $table->foreign('lastMsgSentType')->references('type')->on('send_to_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function ($table) {
            // $table->dropColumn('subscribed_at');
            // $table->dropColumn('unsubscribed_at');
            // $table->dropColumn('googleReviewLinksClicked');
        //     $table->dropForeign('lastMsgSentType');
        //     $table->dropColumn('lastMsgSentType');
        });
    }
};
