<?php

namespace App\Http\Controllers;

use App\Forms\QuestionForm;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Traits\UploadTrait;
use Zofe\Rapyd\DataGrid\DataGrid;

class QuestionController extends Controller
{
    use UploadTrait;

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
//        $dir = 'uploads/script/';
//        $photoDir = 'uploads/images/';
//        $audioDir = 'uploads/audios/';
//        $files = scandir($dir);
//        foreach ($files as $file) {
//            $question_nl = null;
//            $photo = null;
//            $answerA = null;
//            $answerB = null;
//            $answerC = null;
//            $answerD = null;
//            $correctAnswer = null;
//            if ($file != '.' && $file != '..') {
//                $xmls = simplexml_load_file($dir.$file);
//                $fileData = json_decode(json_encode($xmls), true);
//                foreach ($fileData['Element'] as $element) {
//                    if ($element['@attributes']['name'] == 'question.txt') {
//                        $question_nl = $element['Property'][5];
//                    } elseif ($element['@attributes']['name'] == 'answera.txt') {
//                        $answerA = $element['Property'][7];
//
//                    } elseif ($element['@attributes']['name'] == 'answerb.txt') {
//                        $answerB = $element['Property'][7];
//
//                    } elseif ($element['@attributes']['name'] == 'answerc.txt') {
//                        $answerC = $element['Property'][7];
//
//                    } elseif ($element['@attributes']['name'] == 'answera') {
//                        if (isset($element['Property'][1]['@attributes']['name']) && $element['Property'][1]['@attributes']['name'] == 'correct') {
//                            $correctAnswer = '1';
//                        }
//                    } elseif ($element['@attributes']['name'] == 'answerb') {
//                        if (isset($element['Property'][1]['@attributes']['name']) && $element['Property'][1]['@attributes']['name'] == 'correct') {
//                            $correctAnswer = '2';
//                        }
//                    } elseif ($element['@attributes']['name'] == 'answerc') {
//                        if (isset($element['Property'][1]['@attributes']['name']) && $element['Property'][1]['@attributes']['name'] == 'correct') {
//                            $correctAnswer = '3';
//                        }
//                    } elseif ($element['@attributes']['name'] == 'yes') {
//                        if (isset($element['Property'][1]['@attributes']['name']) && $element['Property'][1]['@attributes']['name'] == 'correct') {
//                            $correctAnswer = 'Yes';
//                        }
//                    } elseif ($element['@attributes']['name'] == 'no') {
//                        if (isset($element['Property'][1]['@attributes']['name']) && $element['Property'][1]['@attributes']['name'] == 'correct') {
//                            $correctAnswer = 'No';
//                        }
//                    } elseif ($element['@attributes']['name'] == 'answer') {
//                        if (isset($element['Property'][1])) {
//                            $correctAnswer = $element['Property'][1];
//                        }
//                    } elseif ($element['@attributes']['name'] == 'foto.r') {
//                        $photo = $photoDir.$element['Property'][5];
//                    }elseif ($element['@attributes']['name'] == 'motivate.txt') {
//                        $description = $element['Property'][6];
//                    }elseif ($element['@attributes']['name'] == 'question') {
//                        $audio_nl = $audioDir.$element['Property'];
//                    }
//
//                }
//                Question::create([
//                    'script_name' => $file,
//                    'question_nl' => $question_nl,
//                    'image' => $photo,
//                    'audio_nl' => $audio_nl,
//                    'answer_1' => $answerA,
//                    'answer_2' => $answerB,
//                    'answer_3' => $answerC,
//                    'answer_4' => $answerD,
//                    'correct_answer' => $correctAnswer,
//                    'description_nl' => $description,
//                    'is_free' => 0,
//                ]);
//            }
//        }

        $questions = Question::all();

        return view('question.index', compact('questions'));
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

        Question::create($values);

        return redirect()->route('questions.index')->with(['status' => 'Question added successfully.']);
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
        $form = $formBuilder->create(QuestionForm::class, [
            'method' => 'PUT',
            'url' => route('questions.update',$Question),
            'model' => $Question,
        ]);

        return view('question.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Question $Question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormBuilder $formBuilder, Question $Question)
    {
        $form = $formBuilder->create(QuestionForm::class);
        $values = $form->getFieldValues();

        $Question->fill($values);
        $Question->save();

        return redirect()->route('questions.index')->with(['status' => 'Question updated successfully.']);
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
