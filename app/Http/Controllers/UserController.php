<?php

namespace App\Http\Controllers;

use App\Exam;
use App\User;
use App\Forms\UserForm;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Traits\UploadTrait;
use Zofe\Rapyd\DataGrid\DataGrid;

class UserController extends Controller
{


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
      $Users = User::all();

        return view('user.index', compact('Users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $User,FormBuilder $formBuilder)
    {

        $form = $formBuilder->create(UserForm::class, [
            'method' => 'POST',
            'url' => route('users.index',$User),

        ]);

        return view('user.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class);
        $values = $form->getFieldValues();

        $User = User::create($values);



        return redirect()->route('users.index')->with(['status' => 'User added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Question $Question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $Question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Question $Question
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class, [
            'method' => 'PUT',
            'url' => route('users.update',$User),
            'model' => $User,
        ]);

        return view('user.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function update(User $User,Request $request, FormBuilder $formBuilder)
    {

        $form = $formBuilder->create(UserForm::class);
        $values = $form->getFieldValues();

        $User->fill($values);
        $User->save();

        return redirect()->route('users.index')->with(['status' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Question $Question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $Question)
    {
        //
    }
}
