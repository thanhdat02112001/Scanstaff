<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pads', function (Blueprint $table) {
            $table->char('id', 8);
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('language_id')->unsigned();
            $table->string('title');
            $table->string('status', 15);
            $table->text('content')->nullable();
            $table->text('output')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pads', function (Blueprint $table) {
            $table->dropForeign('pads_user_id_foreign');
            $table->dropForeign('pads_language_id_foreign');
        });
        Schema::dropIfExists('pads');
    }
}
