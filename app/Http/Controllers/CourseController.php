<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    public function show_courses($level_id=null){
        if ($level_id==null){
         return view('courses.index');
        }else{
         return view('courses.index',compact('level_id'));
        }
     }
 
     public function get_courses_data($level_id=null)
     {
         if ($level_id==null){
             $data = Course::with('sections')->orderBy('id')->get();
         }else{
             $data = Course::where('level_id',$level_id)->with('sections')->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('level',function($data){
                 $s=Level::where('id',$data->level_id)->first();
                 return $s->name ?? "-";
             })
             ->addColumn('sections',function($data){
                $s= $data->sections->count();
                // return '<a href="'.route('level_sections').'"class="levels-link">'.$data->sections->count().'</a>';
                 return '<a href="" class="levels-link">'.$s.'</a>';
             })
             ->addColumn('img',function($data){
                return '<img style="width:100px" src="'.$data->img.'"></img>';
             })
             ->addColumn('type', function ($data) {
                if($data->type==0){
                    return '<span class="badge badge-success">مجاني</span>';
                    
                }else{
                    return '<span class="badge badge-primary">مدفوع</span>';
                }
            })
             ->addColumn('action', function ($data) {
                 return view('courses.buttons.actions',compact('data'));
             })
             ->rawColumns(['sections','type','img'])
 
             ->make(true);
     }

     public function store_course(Request $request){
        $request->validate([
            'name'   => 'required',
            'level_id'   => 'required',
            'type'   => 'required|numeric',
        ]);
        $image_file = $request->file('img');
        $image = $image_file->getClientOriginalName();

        $course=new Course();
        $course->name = $request->name;
        $course->level_id = $request->level_id;
        $course->description = $request->description;
        $course->img =asset('Attachments/'.$course->name. '/' . $image);
        $course->type = $request->type;
        $course->save();        
       $image_file->move(public_path('Attachments/' . $course->name), $image);
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_course(Request $request){
        $request->validate([
            'name'    => 'required',
            'level_id'=> 'required',
            'type'    => 'required|numeric',
        ]);
        $course=Course::where('id',$request->id)->first();

        $image_file = $request->file('img');
        $image = $image_file->getClientOriginalName();

        $course->name = $request->name;
        $course->level_id = $request->level_id;
        $course->description = $request->description;
        $course->img =asset('Attachments/'.$course->name. '/' . $image);
        $course->type = $request->type;
        $course->save();        
       $image_file->move(public_path('Attachments/' . $course->name), $image);
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_course(Request $request){
        $s=course::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }
}
