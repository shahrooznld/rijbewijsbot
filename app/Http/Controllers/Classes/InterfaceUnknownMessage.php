<?php


namespace App\Http\Controllers\Classes;



interface InterfaceUnknownMessage
{

    public static function response (Telegram $telegram,$chat_id,$messageId,$keyboard,$adminId = 343463043);

}
