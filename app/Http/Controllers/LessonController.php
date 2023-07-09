<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LessonController extends Controller
{
    public function show_lessons($section_id=null){
        if ($section_id==null){
         return view('lessons.index');
        }else{
         return view('lessons.index',compact('section_id'));
        }
     }
 
     public function get_lessons_data($section_id=null)
     {
         if ($section_id==null){
             $data = Lesson::orderBy('id')->get();
         }else{
             $data = Lesson::where('section_id',$section_id)->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('section',function($data){
                 $s=Section::where('id',$data->section_id)->first();
                 return $s->name.' ( '.$s->course->name.' ) ' ??'-';
             })
             ->addColumn('url_video',function($data){
                return '<a href="'.$data->url_video.'" target="_blank">'.'إضغط لعرض الفيديو'.'</a>';
             })
             ->addColumn('type', function ($data) {
                 if($data->type==0){
                     return '<span class="badge badge-success">مجاني</span>';
                     
                    }else{
                    return '<span class="badge badge-primary">مدفوع</span>';
                }
            })
            ->addColumn('exams',function($data){
                
                return '<a href="'.route('show_quizzes',$data->id).'" class="btn btn-sm btn-primary">'.$data->quizzes->count().'</a>';
            })
            ->addColumn('attachments',function($data){
                
                return '<a href="'.route('show_attachments',$data->id).'" class="btn btn-sm btn-primary">'.$data->attachment->count().'</a>';
            })
             ->addColumn('action', function ($data) {
                 return view('lessons.buttons.actions',compact('data'));
             })
             ->rawColumns(['type','url_video','exams','attachments'])
 
             ->make(true);
     }

     public function store_lesson(Request $request){
        $request->validate([
            'name'   => 'required',
            'section_id'   => 'required',
            'type'   => 'required|numeric',
        ]);
        $lesson=new Lesson();
        $lesson->name = $request->name;
        $lesson->section_id = $request->section_id;
        $lesson->url_video = $request->url_video;
        $lesson->description = $request->description;
        $lesson->type = $request->type;
        $lesson->save();
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_lesson(Request $request){
        $request->validate([
            'name'    => 'required',
            'section_id'=> 'required',
            'type'    => 'required|numeric',
        ]);
        $lesson=Lesson::where('id',$request->id)->first();

        $lesson->name = $request->name;
        $lesson->section_id = $request->section_id;
        $lesson->url_video = $request->url_video;
        $lesson->description = $request->description;
        $lesson->type = $request->type;
        $lesson->save();        
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_lesson(Request $request){
        $s=Lesson::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }

}
