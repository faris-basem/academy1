<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function get_courses_from_levels(Request $request)
    {

        if ($request->level_id == 0) {
            $levels = Level::where('subject_id', $request->subject_id)->pluck('id');
            $courses = Course::whereIn('level_id', $levels)->get();
        } else {
            $courses = Course::where('level_id', $request->level_id)->get();
        }

        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $courses
        ]);
    }

    public function course_by_id(Request $request)
    {
        $course = Course::where('id', $request->course_id)->first();
        $sections = Section::where('course_id', $request->course_id)->pluck('id');
        $lessons = Lesson::whereIn('section_id', $sections)->where('type', 1)->get();
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $course,
            'lessons' => $lessons
        ]);
    }

    public function my_courses()
    {
        $c = Code::where('user_id', Auth::guard('api')->user()->id)->pluck('course_id');
        $courses = Course::whereIn('id', $c)->get();
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $courses,
        ]);
    }

    public function course_by_id_paid(Request $request)
    {
        $c = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $request->course_id)->first();
        if ($c) {
            $course = Course::where('id', $request->course_id)->first();
            $sections=Section::where('course_id',$course->id)->get();
            $course['sections']=$sections;
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $course,
            ]);
        }
    }

    public function latest_courses()
    {
        $co=Course::latest()->paginate(2);
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $co,
        ]);
    }
}
