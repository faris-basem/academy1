<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\StudentPoint;
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

    public function course_by_id(Request $request)
    {
        $c = Code::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $request->course_id)->first();
        $leaders = StudentPoint::where('course_id', $request->course_id)->orderBy('points', 'desc')->get();
        if ($c) {
            $course = Course::where('id', $request->course_id)->first();
            $sections = Section::where('course_id', $course->id)->get();
            $course['sections'] = $sections;
            $course['leader_board'] = $leaders;
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $course,
            ]);
        } else {
            $course = Course::where('id', $request->course_id)->first();
            $sections = Section::where('course_id', $request->course_id)->pluck('id');
            $lessons = Lesson::whereIn('section_id', $sections)->get();
            $lessons1 = Lesson::whereIn('section_id', $sections)->where('type', 1)->get();
            if ($course->type == 1) {
                $course['sections'] = $sections;
                $course['leader_board'] = $leaders;
                return response()->json([
                    'message' => 'Data Fetched Successfully',
                    'code' => 200,
                    'status' => true,
                    'data' => $course,
                    'lessons' => $lessons
                ]);
            } elseif ($course->type == 0 && $lessons1->count() > 0) {
                return response()->json([
                    'message' => 'Data Fetched Successfully',
                    'code' => 200,
                    'status' => true,
                    'data' => $course,
                    'lessons' => $lessons1
                ]);
            } else {
                return response()->json([
                    'message' => 'You Should Buy The Course First',
                    'code' => 403,
                    'status' => false,
                ]);
            }
        }
    }

    public function latest_courses()
    {
        $co = Course::latest()->paginate(2);
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $co,
        ]);
    }

    public function leaderboard(Request $request)
    {
        $std_points = StudentPoint::where('course_id', $request->course_id)->orderBy('points','desc')->paginate(20);
        foreach($std_points as $std_point){
            $u= User::where('id',$std_point->user_id)->first();
            $std_point['student_name']=$u->name;
            $std_point['profile_picture']=$u->img;
        }
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $std_points,
        ]);
    }
}
