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

    public function store_answer(Request $request,$question_id){

        $request->validate([
            'answers.*.answer'   => 'required',
            ]);

       foreach($request->answers as $q){

           $answer1=new answer();
           $answer1->answer = $q['answer'];
           $answer1->status = $q['status'];
           $answer1->question_id = $question_id;
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
    $answer=Answer::where('id',$request->id)->first();
    $answer->answer = $request->answer;
    $answer->status = $request->status;
    $answer->save();
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
