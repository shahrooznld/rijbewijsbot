<?php


namespace App\Http\Controllers\Classes;


use Telegram\Bot\Api;

class Telegram extends Api
{

    public function answerCallbackQuery(array $params)
    {
        $this->post('answerCallbackQuery', $params);
        return true;
    }

}
