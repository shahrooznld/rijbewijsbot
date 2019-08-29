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
            $table->string('script_name')->nullable();
            $table->text('question_nl')->nullable();
            $table->text('question_fa')->nullable();
            $table->string('audio_nl')->nullable();
            $table->string('audio_fa')->nullable();
            $table->string('image')->default('uploads/images/default.jpg')->nullable();
            $table->string('answer_1')->nullable();
            $table->string('answer_2')->nullable();
            $table->string('answer_3')->nullable();
            $table->string('answer_4')->nullable();
            $table->string('correct_answer')->nullable();
            $table->text('description_nl')->nullable();
            $table->text('description_fa')->nullable();
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
