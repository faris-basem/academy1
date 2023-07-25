<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function show_students(){
        return view('student.index');
    }
    public function get_students_data()
    {
        $student = User::orderBy('id')->get();

        return DataTables::of($student)
            ->addIndexColumn()

            ->addColumn('courses', function ($student) {
                $courses = Code::where('user_id' , $student->id)->count();
                return '<a href="'.route('student_courses', ['user_id' => $student->id]).'"><button class="btn btn-sm btn-primary">'.$courses.'</button></a>';
            })
            ->addColumn('action', function ($student) {
                return view('student.buttons.actions',compact('student'));
            })
            ->rawColumns(['courses'])

            ->make(true);
    }

    public function delete_student(Request $request){
        $s=User::where('id',$request->id)->delete();
        return response()->json(['message'=>'deleted successfully']);
    }

    public function student_courses($user_id){
        
         return view('courses.student_courses',compact('user_id'));
        
     }
 
     public function student_courses_data($user_id)
     {
        $u=Code::where('user_id',$user_id)->pluck('course_id');
        $data=Course::whereIn('id',$u)->with('sections')->get();
        
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('level',function($data){
                 $s=Level::where('id',$data->level_id)->first();
                 return $s->name ?? "-";
             })
             ->addColumn('sections',function($data){
                $s= $data->sections->count();
                // return '<a href="'.route('level_sections').'"class="levels-link">'.$data->sections->count().'</a>';
                 return '<a href="'.route('show_sections',$data->id).'" class="levels-link">'.$s.'</a>';
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
             ->rawColumns(['sections','type','img'])
 
             ->make(true);
     }

}
