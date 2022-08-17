<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->char('id', 6);
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('language_id')->unsigned();
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('content')->nullable();
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
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_user_id_foreign');
            $table->dropForeign('questions_language_id_foreign');
        });
        Schema::dropIfExists('questions');
    }
}
