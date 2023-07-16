<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnswerController extends Controller
{
    public function show_answers($question_id){
        
        return view('lessons.answers',compact('question_id'));
    }

    public function get_answers_data($question_id=null)
    {
        if ($question_id==null){
            $data = Answer::orderBy('id')->get();
        }else{
            $data = Answer::where('question_id',$question_id)->orderBy('id')->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if($data->status==0){
                    return '<span class="badge badge-danger">خاطئة</span>';
                    
                }else{
                    return '<span class="badge badge-success">صحيحة</span>';
                }
            })
            ->addColumn('action', function ($data) {
                return view('lessons.buttons.answersActions',compact('data'));
            })
            ->rawColumns(['status'])

            ->make(true);
    }

    public function store_answer(Request $request, $question_id)
{
    $request->validate([
        'answers.*.answer' => 'required',
    ]);

    $answers = $request->answers;

    foreach ($answers as $index => $q) {
        $answer1 = new Answer();
        $answer1->question_id = $question_id;
        $answer1->answer = $q['answer'];

        if ($request->hasFile('answers.'.$index.'.answer')) {
            $image_file = $request->file('answers.'.$index.'.answer');
            $answer_name = 'answer_' . time() . '_' . uniqid() . '.' . $image_file->getClientOriginalExtension();
            $answer1->status = $q['status']; // Set the status from $request->answers
            $answer_path = 'Attachments/' . 'answers/' . $question_id;

            $image_file->move(public_path($answer_path), $answer_name); // Move the file to the desired location

            $answer1->answer = asset($answer_path . '/' . $answer_name);
        } else {
            $answer1->status = $q['status']; // Set the status from $request->answers
        }

        $answer1->save();
    }
   
       return response()->json([
           'message'=>'add success'
       ]);
   }

   public function edit_answer(Request $request){
    $request->validate([
        'answer'    => 'required',
        'status'    => 'required',
    ]);

    if ($request->hasFile('answer')) {
        $answer_file = $request->file('answer');
        $answer_name = 'answer_' . time() . '_' . uniqid() . '.' . $answer_file->getClientOriginalExtension();

        $answerAttachment = Answer::where('id', $request->id)->first();
        $answer_path = 'Attachments/' . 'answers/' . $answerAttachment->question_id;
        $answerAttachment->answer = asset($answer_path . '/' . $answer_name);
        $answerAttachment->status = $request->status;
        $answerAttachment->save();

        $answer_file->move(public_path($answer_path), $answer_name);

    } else {
        $answer=Answer::where('id',$request->id)->first();
        $answer->answer = $request->answer;
        $answer->status = $request->status;
        $answer->save();
    }
    return response()->json([
        'message'=>'edited success'
    ]);
}

public function delete_answer(Request $request){
    $s=Answer::where('id',$request->id)->delete();
    return response()->json([
        'message'=>'deleted successfully'
    ]);
}


}
