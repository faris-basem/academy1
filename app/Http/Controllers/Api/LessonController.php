<?php

namespace App\Http\Controllers\Api;

use App\Models\Code;
use App\Models\Lesson;
use App\Models\Replie;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Commetlike;
use App\Models\ReplieLike;
use Illuminate\Http\Request;
use App\Models\LessonAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function lesson_by_id(Request $request)
    {
        $lesson=Lesson::where('id',$request->lesson_id)->with('comments','attachment')->first();
        $sec=Section::where('id',$lesson->section_id)->first();
        if($lesson->type==0){
            $sub=Code::where('user_id',Auth::guard('api')->user()->id)->where('course_id', $sec->course_id)->first();
            if($sub){
                return response()->json([
                    'message' => 'Data Fetched Successfully',
                    'code' => 200,
                    'status'=>true,
                    'data'=>$lesson
                ]);
            }else{
                return response()->json([
                    'message' =>'You Should Buy the course First',
                    'code' => 200,
                    'status'=>false
                ]);
            }
        }else{
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status'=>true,
                'data'=>$lesson
            ]);
        }
    }

    public function add_lesson_attachment(Request $request)
    {
        $attachmentFile = $request->file('attachment');
        $file_name = $attachmentFile->getClientOriginalName();

        $attachment = new LessonAttachment();
        $attachment->file_name = $file_name;
        $attachment->lesson_id = $request->lesson_id;
        $attachment->file_link = asset('Attachments/' . $request->lesson_id . '/' . $file_name);
        $attachment->save();

        $attachmentFile->move(public_path('Attachments/' . $request->lesson_id), $file_name);

        return response()->json([
            'message' => 'File Added Successfully',
            'code' => 200,
            'status' => true,
            'attachment' => $attachment, 
        ]);
    }
}
