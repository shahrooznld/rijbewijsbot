<?php


namespace App\Http\Controllers;


use App\Bot;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Telegram\Bot\Api;

class Answer
{
    protected $telegram;
    protected $updates;
    protected $update_id;
    protected $message;
    protected $messageId;
    protected $chat_id;
    protected $username;
    protected $firstName;
    protected $lastName;
    protected $text;

    public function __construct()
    {
        $this->telegram = new Api('741743493:AAGVwSJbeHENq3e0QtACLLSL-N6-AxcYYfg');
    }

    public function SaveTextAndAnswer()
    {
        $this->updates = $this->telegram->getUpdates();
        foreach ($this->updates as $update) {

            $this->update_id = $update->getUpdateId();
            $this->message = ! is_null($update->getMessage()) ? $update->getMessage() : $update->getEditedMessage();
            $this->messageId = $this->message->getMessageId();
            $this->chat_id = $this->message->getChat()->getId();
            $this->username = $this->message->getChat()->getUsername();
            $this->firstName = $this->message->getChat()->getFirstName();
            $this->lastName = $this->message->getChat()->getLastName();
            $this->text = $this->message->getText();
            $user = User::firstOrCreate(['telegram_user_id' => $this->chat_id], [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'telegram_username' => $this->username,
            ]);

            $user->bots()->create([
                'update_id' => $this->update_id,
                'telegram_user_id' => $this->chat_id,
                'telegram_message_id' => $this->messageId,
                'text' => $this->text,
            ]);
            //var_dump($this->text);
            $this->Answer();
        }

    }

    public function Answer()
    {
        if ($this->text == '/start') {
            $this->startBot();
        } elseif ($this->text == 'شروع تست آنلاین') {
            $this->startTest();
        } elseif ($this->text == 'تست بعدی') {
            $this->nextTest();
        } else {
            $this->checkAnswer($this->message);
        }

    }

    public function generateKeyboard($type)
    {
        if ($type == 'start') {
            $keyboard = [
                ['شروع تست آنلاین', 'تماس با ما'],
            ];

            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;
        } elseif ($type == 'nextTest') {
            $keyboard = [
                ['1', '2', '3', '4'],
                ['تست بعدی'],
            ];

            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        }elseif ($type == 'notMoreQuestion') {
            $keyboard = [

                ['بازگشت'],
            ];

            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        }
    }

    public function startBot()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'سلام به ربات آموزش رانندگی و تست آنلاین رانندگی خوش آمدید.برای شروع تست آنلاین بر روی گزینه شروع تست بزنید',
            'reply_markup' => $this->generateKeyboard('start'),
        ]);


    }

    public function startTest()
    {
        $question = Question::with('users')->whereDoesntHave('users', function (Builder $query) {
            $query->where('telegram_user_id', $this->chat_id);
        })->first();
        if(!is_null($question)) {
        $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $question->question_nl,
            'reply_markup' => $this->generateKeyboard('nextTest'),
        ]);
        $user = User::with('questions')->where('telegram_user_id', $this->chat_id)->first();
        $user->questions()->attach([$question->id]);
        }else{
           $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'سولات شما به پایان رسیده است',
            'reply_markup' => $this->generateKeyboard('notMoreQuestion'),
        ]);
        }
    }

    public function nextTest()
    {
           $question = Question::with('users')->whereDoesntHave('users', function (Builder $query) {
            $query->where('telegram_user_id', $this->chat_id);
        })->first();
        if(!is_null($question)) {
        $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $question->question_nl,
            'reply_markup' => $this->generateKeyboard('nextTest'),
        ]);
        $user = User::with('questions')->where('telegram_user_id', $this->chat_id)->first();
        $user->questions()->attach([$question->id]);
        }else{
           $this->telegram->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'سولات شما به پایان رسیده است',
            'reply_markup' => $this->generateKeyboard('notMoreQuestion'),
        ]);
        }
    }

    public function checkAnswer()
    {

    }

}
