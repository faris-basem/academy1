<?php

namespace App\Http\Controllers\Api;

use App\Models\Code;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function section_by_id(Request $request)
    {
        $sec=Section::where('id',$request->section_id)->with('lessons.quizzes')->first();
        $sub=Code::where('user_id',Auth::guard('api')->user()->id)->where('course_id', $sec->course_id)->first();
        if($sub){
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status'=>true,
                'data'=>$sec
            ]);
        }else{
            return response()->json([
                'message' =>'You Should Buy the Course First',
                'code' => 403,
                'status'=>false
            ]);
        }
    }
}
