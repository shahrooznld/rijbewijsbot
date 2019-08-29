<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Forms\SendToAllForm;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;


class SendToAllController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('send.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(SendToAllForm::class, [
            'method' => 'POST',
            'url' => route('sends.store'),

        ]);

        return view('send.create', compact('form'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(SendToAllForm::class);
        $values = $form->getFieldValues();

        $users = User::all();
        foreach ($users as $user) {
            if (! is_null($user->telegram_user_id)) {
                try {
                    $response = Telegram::sendMessage([
                        'chat_id' => $user->telegram_user_id,
                        'text' => $values['SendToAll'],
                    ]);
                } catch (\Exception $e) {
                    Telegram::sendMessage([
                        'chat_id' => '343463043',
                        'text' => $user->telegram_user_id."Blocked You",
                    ]);

                }
            }


        }

        return redirect()->route('sends.index')->with(['status' => 'Message sent.']);
    }
}
