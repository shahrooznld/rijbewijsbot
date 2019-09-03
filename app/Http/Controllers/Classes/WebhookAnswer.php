<?php


namespace App\Http\Controllers\Classes;


use App\Bot;
use App\Exam;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Telegram\Bot\Api;

class WebhookAnswer extends Answer
{

  public function SaveTextAndAnswer()
  {
    $this->updates = $this->telegram->getWebhookUpdates();


    $update = $this->updates;
    if (isset($update["callback_query"])) {

      $this->callback_query = $update["callback_query"]["data"];
      $this->update_id = $update->getUpdateId();
      $this->message = $update["callback_query"]["message"];
      $this->messageId = $update["callback_query"]["message"]["message_id"];
      $this->chat_id = $this->message->getChat()->getId();
      $this->username = $this->message->getChat()->getUsername();
      $this->firstName = $this->message->getChat()->getFirstName();
      $this->lastName = $this->message->getChat()->getLastName();
      $this->text = $this->message->getText();

    } else {

      $this->update_id = $update->getUpdateId();
      $this->message = ! is_null($update->getMessage()) ? $update->getMessage() : $update->getEditedMessage();
      $this->messageId = $this->message->getMessageId();
      $this->chat_id = $this->message->getChat()->getId();
      $this->username = $this->message->getChat()->getUsername();
      $this->firstName = $this->message->getChat()->getFirstName();
      $this->lastName = $this->message->getChat()->getLastName();
      $this->text = $this->message->getText();
    }

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
    if (isset($this->callback_query)) {
      $this->CallbackQueryAnswer();
    } else {
      $this->Answer();
    }

  }


}
