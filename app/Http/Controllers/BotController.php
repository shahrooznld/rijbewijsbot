<?php

namespace App\Http\Controllers;

use App\Bot;
use App\Http\Controllers\Classes\UpdateAnswer;
use App\Http\Controllers\Classes\WebhookAnswer;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $answer = new UpdateAnswer();
        $answer->SaveTextAndAnswer();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//
        $answer = new WebhookAnswer();
        $answer->SaveTextAndAnswer();
//        Telegram::sendMessage([
//            'chat_id' => 343463043,
//              'text' => 'x',
//           ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function show(Bot $bot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot $bot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bot $bot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot $bot)
    {
        //
    }
}
