<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LessonQuizController extends Controller
{
    public function show_quizzes($lesson_id=null){
        if ($lesson_id==null){
         return view('lessons.quizzes');
        }else{
         return view('lessons.quizzes',compact('lesson_id'));
        }
     }
 
     public function get_quizzes_data($lesson_id=null)
     {
         if ($lesson_id==null){
             $data = Quiz::orderBy('id')->get();
         }else{
             $data = Quiz::where('lesson_id',$lesson_id)->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('name',function($data){


                $str_len = Str::length($data->name);

                if($str_len > 10){

                     $name =  Str::substr($data->name, 0,10) . '...';
                    return '<a href="#" style="color: inherit; cursor: default;"  title="'.$data->name.'">'.$name .'</a>';
                }else{
                    return $data->name;
                }             
            })

             ->addColumn('lesson',function($data){
                 $s=Lesson::where('id',$data->lesson_id)->first();
                 return $s->name.' ( '.$s->section->name.' ) ' ??'-';
             })
             ->addColumn('question_num',function($data){
                 return '<a href="'.route('show_quizzes',$data->lesson_id).'" class="btn btn-sm btn-primary">'.$data->question_num.'</a>';
             })
             
             ->addColumn('action', function ($data) {
                 return view('lessons.buttons.quizzesActions',compact('data'));
             })
             ->rawColumns(['name','question_num','lesson'])
 
             ->make(true);
     }

     public function store_quiz(Request $request){
        $request->validate([
            'name'                  => 'required',
            'lesson_id'             => 'required',
            'type'                  => 'required',
            'time'                  => 'required|numeric',
            'question_num'          => 'required|numeric',
            'attempts'              => 'required|numeric',
            'points'                => 'required|numeric',
            'deduction_per_attempt' => 'required|numeric',
            'notes'                 => 'required',
        ]);
        $quiz=new Quiz();
        $quiz->name = $request->name;
        $quiz->lesson_id = $request->lesson_id;
        $quiz->type = $request->type;
        $quiz->time = $request->time;
        $quiz->question_num = $request->question_num;
        $quiz->attempts = $request->attempts;
        $quiz->points = $request->points;
        $quiz->deduction_per_attempt = $request->deduction_per_attempt;
        $quiz->notes = $request->notes;
        $quiz->save();
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_quiz(Request $request){
        $request->validate([
            'name'                  => 'required',
            'lesson_id'             => 'required',
            'type'                  => 'required',
            'time'                  => 'required|numeric',
            'question_num'          => 'required|numeric',
            'attempts'              => 'required|numeric',
            'points'                => 'required|numeric',
            'deduction_per_attempt' => 'required|numeric',
            'notes'                 => 'required',
        ]);
        $quiz=Quiz::where('id',$request->id)->first();

        $quiz->name = $request->name;
        $quiz->lesson_id = $request->lesson_id;
        $quiz->type = $request->type;
        $quiz->time = $request->time;
        $quiz->question_num = $request->question_num;
        $quiz->attempts = $request->attempts;
        $quiz->points = $request->points;
        $quiz->deduction_per_attempt = $request->deduction_per_attempt;
        $quiz->notes = $request->notes;
        $quiz->save();
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_quiz(Request $request){
        $s=Quiz::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }

}
