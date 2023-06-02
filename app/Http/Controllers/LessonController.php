<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function get_free_lesson_by_id(Request $request)
    {
        $lesson=Lesson::where('id',$request->lesson_id)->first();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status'=>true,
                'data'=>$lesson
            ]);
    }
}
