<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idSurvey)
    {
        $survey = \App\Survey::findOrFail($idSurvey);

        $questions = $survey->questions;

        return response()->json([
            "data" => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|max:255",
            "type" => "required|in:".implode(',',Question::$type),
            "options" => "nullable|array",
            "survey_id" => "required|exists:surveys,id",
        ]);

        $request->options = implode(",", $request->options);

        $question = Question::create($request->all());

        return response()->json([
            "id" => $question->id,
            "event" => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return response()->json([
            "data" => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            "title" => "required|max:255",
            "type" => "required|in:".implode(',',Question::$type),
            "options" => "nullable",
            "survey_id" => "required|exists:surveys,id",
        ]);

        $request->options = implode(",", $request->options);

        $question->update($request->all());

        return response()->json([
            "id" => $question->id,
            "event" => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json([
            "id" => $question->id,
            "event" => true
        ]);
    }
}
