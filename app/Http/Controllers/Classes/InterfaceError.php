<?php


namespace App\Http\Controllers\Classes;


interface InterfaceError
{

    public static function UnknownMessage(Telegram $telegram, $chat_id);

}
