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

        try {
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

//        $this->telegram->sendMessage([
//                'chat_id' => 343463043,
//                'text' => $this->text,
//
//            ]);
//        dd('yes');
//
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
        } catch (Exception $e) {
            $this->telegram->sendMessage([
                'chat_id' => 343463043,
                'text' => 'Error : '.$this->text,

            ]);
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'مشکلی پیش آمده دوباره سعی  کنید',
                'reply_markup' => $this->generateKeyboard('unknowenRequest'),

            ]);
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
        } elseif ($this->text == 'ادامه پاسخگویی به سوالات') {
            $this->nextTest();
        } elseif ($this->text == 'تماس با ما') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'برای تماس با بخش مدیریت به نام کاربری @shahrooz_nld پیغام دهید',
                'reply_markup' => $this->generateKeyboard('mainMenu'),
            ]);
        } elseif ($this->text == 'منوی اصلی') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'شما به بخش منوی اصلی انتقال پیدا کردید لطفا یکی از گزینه های زیر را انتخاب کنید',
                'reply_markup' => $this->generateKeyboard('mainMenu'),
            ]);
        } elseif ($this->text == 'توضیحات در مورد ربات آموزشی رانندگی') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'این ربات تلگرام با داشتن بیش از 1000 نمونه سوالات آزمون راهنمایی رانندگی برای فارسی زبان ها تهیه شده است. برای شروع می توانید در قسمت منوی کیبورد گزینه شروع تست را انتخاب کنید. سوالات به دو زبان فارسی و هلندی به همراه عکس و صدا فرستاده میشود.بعد از خواندن سوال میتوانی به آن پاسخ دهدید.که بعد پاسخ شما ربات به شما اطلاع میدهد که جواب شما صحیح می باشد با خیر',
                'reply_markup' => $this->generateKeyboard('mainMenu'),
            ]);
        } elseif ($this->text == 'خرید اشتراک') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'با خرید اشتراک شما به تمامی سوالات به صورت نامحدود دسترسی خواهید داشت و میتوانید این سوالات را به صورت مداوم تمرین کنید.برای خرید به آی دی تلگرام @shahrooz_nl پیغام دهید',
                'reply_markup' => $this->generateKeyboard('mainMenu'),
            ]);
        } elseif ($this->text == 'تعیین نوبت امتحانCBR') {
            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'سلام برای تعیین وقت آنلاین در سایت CBR و یا مشاوره به آی دی تلگرام @shahrooz_nl پیغام دهید',
                'reply_markup' => $this->generateKeyboard('mainMenu'),
            ]);

        } else {
            $this->checkAnswer();
        }

    }

    public function generateKeyboard($type, $question = null)
    {
        if ($type == 'start') {
            $keyboard = [
                ['شروع تست آنلاین', 'تماس با ما'],
                ['توضیحات در مورد ربات آموزشی رانندگی'],
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

        } elseif ($type == 'mainMenu') {
            $keyboard = [
                ['شروع تست آنلاین', 'تماس با ما'],
                ['ادامه پاسخگویی به سوالات', 'تعیین نوبت امتحانCBR'],
                ['توضیحات در مورد ربات آموزشی رانندگی'],
//                ['خرید اشتراک'],
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
                ['منوی اصلی'],
            ];


            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        } elseif ($type == 'notMoreQuestion') {
            $keyboard = [
                ['منوی اصلی'],
                ['خرید اشتراک'],
            ];

            $reply_markup = $this->telegram->replyKeyboardMarkup([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]);

            return $reply_markup;

        } elseif ($type = 'unknowenRequest') {
            $keyboard = [
                ['منوی اصلی'],
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
        $user = User::where('telegram_user_id', $this->chat_id)->first();
        $user->questions()->detach();
        $question = Question::with('users')->whereDoesntHave('users', function (Builder $query) {
            $query->where('telegram_user_id', $this->chat_id);
        })->first();
        //})->free()->first();
        if (! is_null($question)) {
            $question->image = $question->image ?? 'uploads/images/default.jpg';
            $this->telegram->sendPhoto([
                'chat_id' => $this->chat_id,
                'photo' => $question->image,
                'caption' => $question->id.' :'.$question->question_nl.PHP_EOL.PHP_EOL.$question->TextAnswer.PHP_EOL.PHP_EOL.$question->question_fa.PHP_EOL.PHP_EOL.$question->TextAnswerFA,
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
        $user = User::with([
            'questions' => function ($query) {
                $query->orderBy('pivot_created_at', 'DESC');
            },
        ])->where('telegram_user_id', $this->chat_id)->first();

        $currentQuestion = $user->questions->first();
        if (! is_null($currentQuestion) && is_null($currentQuestion->pivot->answer)) {

            $this->telegram->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'شما به سوال قبل خود پاسخ نداده اید لطفا پاسخ سوال قبل خود را بدهید',
                'reply_markup' => $this->generateKeyboard('answerKeyboard', $currentQuestion),
            ]);
        } else {


            $question = Question::with('users')->whereDoesntHave('users', function (Builder $query) {
                $query->where('telegram_user_id', $this->chat_id);
            })->first();
            //})->free()->first();
            if (! is_null($question)) {
                $question->image = $question->image ?? 'uploads/images/default.jpg';
                $this->telegram->sendPhoto([
                    'chat_id' => $this->chat_id,
                    'photo' => $question->image,
                    'caption' => $question->id.' :'.$question->question_nl.PHP_EOL.PHP_EOL.$question->TextAnswer.PHP_EOL.PHP_EOL.$question->question_fa.PHP_EOL.PHP_EOL.$question->TextAnswerFA,
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
                    'text' => 'جواب شما درست است✅'.PHP_EOL.' Tips:'.PHP_EOL.$currentQuestion->description_nl.PHP_EOL.'نکته آموزشی'.PHP_EOL.$currentQuestion->description_fa,
                    'reply_markup' => $this->generateKeyboard('nextTest'),
                ]);

            } else {
                $this->telegram->sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => 'جواب شما درست نیست❌'.PHP_EOL.'جواب صحیح: '.PHP_EOL.$currentQuestion->correct_answer.PHP_EOL.' Tips:'.PHP_EOL.PHP_EOL.$currentQuestion->description_nl.PHP_EOL.PHP_EOL.'نکته آموزشی'.PHP_EOL.PHP_EOL.$currentQuestion->description_fa,
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
