<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('question_nl')->nullable();
            $table->string('question_fa')->nullable();
            $table->string('audio_nl')->nullable();
            $table->string('audio_fa')->nullable();
            $table->string('image')->nullable();
            $table->string('keyboard_answer')->nullable();
            $table->string('correct_answer')->nullable();
            $table->boolean('is_free')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
