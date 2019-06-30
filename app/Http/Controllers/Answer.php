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

        $this->updates = $this->telegram->getWebhookUpdates();
        $update = $this->updates;

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

    public function Answer()
    {
        if ($this->text == '/start') {
            $this->startBot();
        } elseif ($this->text == 'شروع تست آنلاین') {
            $this->startTest();
        } elseif ($this->text == 'تست بعدی') {
            $this->nextTest();
        } else {
            $this->checkAnswer();
        }

    }

    public function generateKeyboard($type, $question = null)
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
        } elseif ($type == 'answerKeyboard') {
            $keyboard = [
                $question->keyboard,
            ];


            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        } elseif ($type == 'nextTest') {
            $keyboard = [
                ['تست بعدی'],
            ];


            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        } elseif ($type == 'notMoreQuestion') {
            $keyboard = [

                ['بازگشت'],
            ];

            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        } elseif ($type = 'unknowenRequest') {
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
        })->free()->first();
        if (! is_null($question)) {
            $question->image = $question->image ?? 'uploads/images/default.jpg';
            $this->telegram->sendPhoto([
                'chat_id' => $this->chat_id,
                'photo' => $question->image,
                'caption' => $question->question_nl.PHP_EOL.PHP_EOL.$question->question_fa.PHP_EOL.$question->TextAnswer,
                'reply_markup' => $this->generateKeyboard('answerKeyboard', $question),
            ]);
            $this->telegram->sendVoice([
                'chat_id' => $this->chat_id,
                'voice' => $question->audio_nl,
            ]);

            $user = User::with('questions')->where('telegram_user_id', $this->chat_id)->first();
            $user->questions()->attach([$question->id]);
        } else {
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
        })->free()->first();
        if (! is_null($question)) {
            $question->image = $question->image ?? 'uploads/images/default.jpg';
            $this->telegram->sendPhoto([
                'chat_id' => $this->chat_id,
                'photo' => $question->image,
                'caption' => $question->question_nl.PHP_EOL.PHP_EOL.$question->question_fa.PHP_EOL.$question->TextAnswer,
                'reply_markup' => $this->generateKeyboard('answerKeyboard', $question),
            ]);
            $this->telegram->sendVoice([
                'chat_id' => $this->chat_id,
                'voice' => $question->audio_nl,
            ]);

            $user = User::with('questions')->where('telegram_user_id', $this->chat_id)->first();
            $user->questions()->attach([$question->id]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'سولات شما به پایان رسیده است',
                'reply_markup' => $this->generateKeyboard('notMoreQuestion'),
            ]);
        }
    }

    public function checkAnswer()
    {
        $user = User::with([
            'questions' => function ($query) {
                $query->orderBy('pivot_created_at', 'DESC');
            },
        ])->where('telegram_user_id', $this->chat_id)->first();

        $currentQuestion = $user->questions->first();
        if (! is_null($currentQuestion) && is_null($currentQuestion->pivot->answer)) {
            $currentQuestion->pivot->answer = $this->text;
            $currentQuestion->pivot->save();

            if ($currentQuestion->correct_answer == $this->text) {
                $this->telegram->sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => 'جواب شما درست است'.PHP_EOL.' Tips:'.PHP_EOL.$currentQuestion->description_nl.PHP_EOL.'نکته آموزشی'.PHP_EOL.$currentQuestion->description_fa,
                    'reply_markup' => $this->generateKeyboard('nextTest'),
                ]);

            } else {
                $this->telegram->sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => 'جواب شما درست نیست'.PHP_EOL.'جواب صحیح: '.PHP_EOL.$currentQuestion->correct_answer.PHP_EOL.' Tips:'.PHP_EOL.PHP_EOL.$currentQuestion->description_nl.PHP_EOL.PHP_EOL.'نکته آموزشی'.PHP_EOL.PHP_EOL.$currentQuestion->description_fa,
                    'reply_markup' => $this->generateKeyboard('nextTest'),
                ]);

            }
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'جوابی برای درخواست شما وجود ندارد لطفا یکی از منو زیر را انتخاب کنید',
                'reply_markup' => $this->generateKeyboard('unknowenRequest'),

            ]);

        }

    }

}
