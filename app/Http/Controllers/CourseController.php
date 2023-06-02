<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function get_courses_from_levels(Request $request)
    {

        if($request->level_id == 0){
            $levels=Level::where('subject_id',$request->subject_id)->pluck('id');
            $courses=Course::whereIn('level_id',$levels)->get();
        }else{
            $courses=Course::where('level_id',$request->level_id)->get();
        }
      
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$courses
        ]);
    }

    public function course_by_id(Request $request)
    {
        $course=Course::where('id',$request->course_id)->first();
        $sections=Section::where('course_id',$request->course_id)->pluck('id');
        $lessons=Lesson::whereIn('section_id',$sections)->where('type',1)->get();
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$course,
            'lessons'=>$lessons
        ]);
    }

}
