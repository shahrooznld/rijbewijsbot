<?php


namespace App\Http\Controllers\Classes;


class UnknownMessage implements InterfaceUnknownMessage
{

  public static function response (Telegram $telegram,$chat_id,$messageId,$keyboard,$adminId = 343463043)
  {
    $telegram->forwardMessage([
      'chat_id' => $adminId,
      'from_chat_id' => $chat_id,
      'message_id' => $messageId,
    ]);
    $telegram->sendMessage([
      'chat_id' => $chat_id,
      'text' => 'جوابی برای درخواست شما وجود ندارد لطفا یکی از منو زیر را انتخاب کنید',
      'reply_markup' => $keyboard,

    ]);

  }
}
