<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function show_questions($quiz_id){
        
         return view('lessons.questions',compact('quiz_id'));
     }

     public function get_questions_data($quiz_id=null)
     {
         if ($quiz_id==null){
             $data = Question::orderBy('id')->get();
         }else{
             $data = Question::where('quiz_id',$quiz_id)->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('quiz',function($data){
                 $s=Quiz::where('id',$data->quiz_id)->first();
                 return $s->name.' ( '.$s->lesson->name.' ) ' ??'-';
             })
             ->addColumn('answers',function($data){
                return '<a href="'.route('show_answers',$data->id).'" class="btn btn-sm btn-primary">'.$data->answers->count().'</a>';
             })
             ->addColumn('action', function ($data) {
                 return view('lessons.buttons.questionsActions',compact('data'));
             })
             ->rawColumns(['quiz','answers'])
 
             ->make(true);
     }


     public function store_question(Request $request,$quiz_id){

         $request->validate([
             'questions.*.question'   => 'required',
             ]);


             if($request->hasFile('questions.*.question')){
                $quest=$request->file('questions');
                foreach($quest as $q){
                    $image_file = $q['question'];
                    $question_name = 'question_' . time() . '_' . uniqid() . '.' . $image_file->getClientOriginalExtension();
                    $question1=new Question();

                    $question_path = 'Attachments/' . 'questions/' . $quiz_id;

                    $question1->question = asset($question_path . '/' . $question_name);

                    $question1->quiz_id = $quiz_id;
                    
                    $question1->save();
                    
                    $image_file->move(public_path($question_path), $question_name);
                }
            }else{

                foreach($request->questions as $q){


                    $question1=new Question();
                    $question1->quiz_id = $quiz_id;
        
                    $question1->question = $q['question'];
                    $question1->save();
                    
                }
            }

        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_question(Request $request){

        $request->validate([
            'question' => 'required',
        ]);
    
        if ($request->hasFile('question')) {
            $question_file = $request->file('question');
            $question_name = 'question_' . time() . '_' . uniqid() . '.' . $question_file->getClientOriginalExtension();
    
            $questionAttachment = Question::where('id', $request->id)->first();
            $question_path = 'Attachments/' . 'questions/' . $questionAttachment->quiz_id;
            $questionAttachment->question = asset($question_path . '/' . $question_name);
            $questionAttachment->save();
    
            $question_file->move(public_path($question_path), $question_name);
        } else {
            $question = Question::where('id', $request->id)->first();
            $question->question = $request->question;
            $question->save();
        }
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_question(Request $request){
        $s=Question::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }


}
