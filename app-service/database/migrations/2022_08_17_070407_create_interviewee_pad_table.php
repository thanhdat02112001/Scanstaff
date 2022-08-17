<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervieweePadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviewee_pad', function (Blueprint $table) {
            $table->char('pad_id', 8);
            $table->bigInteger('interviewee_id')->unsigned();
            $table->timestamps();
            $table->primary(['pad_id', 'interviewee_id']);
            $table->foreign('pad_id')->references('id')->on('pads');
            $table->foreign('interviewee_id')->references('id')->on('interviewees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interviewee_pad', function (Blueprint $table) {
            $table->dropForeign('interviewee_pad_pad_id_foreign');
            $table->dropForeign('interviewee_pad_interviewee_id_foreign');
        });
        Schema::dropIfExists('interviewee_pad');
    }
}
