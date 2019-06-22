<?php

namespace App\Http\Controllers;

use App\Forms\QuestionForm;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Traits\UploadTrait;

class QuestionController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(QuestionForm::class, [
            'method' => 'POST',
            'url' => route('questions.index'),

        ]);

        return view('question.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(QuestionForm::class);
        $values = $form->getFieldValues();

        if ($request->has('image')) {
            $image = $request->file('image');
            $name = 'question_'.time();
            $folder = '/uploads/images/';
            $filePath = $folder.$name.'.'.$image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $values['image'] = $filePath;
        }
        Question::create($values);
        return redirect()->route('bots.index')->with(['status' => 'Question added successfully.']);
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
    public function edit(Question $Question, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(QuestionForm::class,[
            'method' => 'PUT',
            'url' => route('questions.store'),
            'model' => $Question,
        ]);
        return view('question.edit',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Question $Question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $Question)
    {
        //
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
