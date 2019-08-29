<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Forms\ExamForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::all();

        return view('exam.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ExamForm::class, [
            'method' => 'POST',
            'url' => route('exams.index'),

        ]);

        return view('exam.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ExamForm::class);
        $values = $form->getFieldValues();

        Exam::create($values);

        return redirect()->route('exams.index')->with(['status' => 'Exam added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ExamForm::class, [
            'method' => 'PUT',
            'url' => route('exams.update', $exam),
            'model' => $exam,
        ]);

        return view('exam.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormBuilder $formBuilder, Exam $exam)
    {
        $form = $formBuilder->create(ExamForm::class);
        $values = $form->getFieldValues();

        $exam->fill($values);
        $exam->save();

        return redirect()->route('exams.index')->with(['status' => 'Exam updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Exam $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
    }
}
