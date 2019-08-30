<?php


namespace App\Http\Controllers;


use App\Bot;
use App\Exam;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Telegram\Bot\Api;

interface InterfaceAnswer
{

    public function SaveTextAndAnswer();

    public function CallbackQueryAnswer();

    public function Answer();

    public function generateKeyboard($type, $question = null);

    public function startBot();

    public function listTest();

    public function nextTest();

    public function checkAnswer();

}
