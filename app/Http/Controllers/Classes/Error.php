<?php


namespace App\Http\Controllers\Classes;



class Error implements InterfaceError
{


  public static function UnknownMessage(Telegram $telegram, $chat_id){
    $telegram->sendMessage([
      'chat_id' => $this->chat_id,
      'text' => 'جوابی برای درخواست شما وجود ندارد لطفا یکی از منو زیر را انتخاب کنید',
      'reply_markup' => $this->generateKeyboard('unknowenRequest'),

    ]);

  }


}
