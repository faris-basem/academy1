<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function genarate(Request $request)
    {
        $num = $request->num;
        for ($i = 0; $i < $num; $i++) {
            $c = new Code();
            $c->code = Str::random(6);
            $c->course_id = $request->course_id;
            $c->save();
        }
        return response()->json([
            'message' => $request->num . ' Codes Created Successfully',
            'code' => 200,
            'status' => true,
        ]);
    }
    public function subscribe(Request $request)
    {
        $code = Code::where('code', $request->code)->first();
        if ($code) {
            if ($code->status == 0) {
                $course = Course::where('id', $request->course_id)->first();
                if ($code->course_id == $course->id) {
                    $code->status = 1;
                    $code->user_id = Auth::guard('api')->user()->id;
                    $code->save();
                    return response()->json([
                        'message' => 'Subscribed successfully',
                        'code' => 200,
                        'status' => true,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'This code is not for this course',
                        'code' => 404,
                        'status' => false,
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'This code already used',
                    'code' => 404,
                    'status' => false,
                ]);
            }
        } else {
            return response()->json([
                'message' => 'This code is not valid',
                'code' => 404,
                'status' => false,
            ]);
        }
    }
}
