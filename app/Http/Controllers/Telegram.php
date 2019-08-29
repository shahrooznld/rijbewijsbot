<?php


namespace App\Http\Controllers;


use Telegram\Bot\Api;

class Telegram extends Api
{

    public function answerCallbackQuery(array $params)
    {
        $this->post('answerCallbackQuery', $params);
        return true;
    }

}
