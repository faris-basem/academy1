<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonAttachment;
use Yajra\DataTables\DataTables;

class LessonAttachmentController extends Controller
{
    public function show_attachments($lesson_id=null){
        if ($lesson_id==null){
         return view('lessons.attachments');
        }else{
         return view('lessons.attachments',compact('lesson_id'));
        }
     }
 
     public function get_attachments_data($lesson_id=null)
     {
         if ($lesson_id==null){
             $data = LessonAttachment::orderBy('id')->get();
         }else{
             $data = LessonAttachment::where('lesson_id',$lesson_id)->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('lesson',function($data){
                 $s=Lesson::where('id',$data->lesson_id)->first();
                 return $s->name.' ( '.$s->section->name.' ) ' ??'-';
             })
             ->addColumn('file_link',function($data){
                return '<a href="'.$data->file_link.'" class="btn btn-sm btn-primary" target="_blank"><i class="fa-solid fa-eye"></i>&nbsp'.'عرض المرفق'.'</a> &nbsp'.' <a href="'.$data->file_link.'" download class="btn btn-sm btn-success" target="_blank"><i class="fas fa-download"></i>&nbsp'.'تحميل المرفق'.'</a>';
             })
             
             ->addColumn('action', function ($data) {
                 return view('lessons.buttons.attachmentsActions',compact('data'));
             })
             ->rawColumns(['type','lesson','file_link'])
 
             ->make(true);
     }

     public function store_attachment(Request $request){
        $request->validate([
            'file_name'   => 'required',
            'lesson_id'   => 'required',
            'file_link'=> 'required',
        ]);
        $file_link = $request->file('file_link');
        // $link = $file_link->getClientOriginalName();

        $attachment=new LessonAttachment();
        $attachment->file_name = $request->file_name;
        $attachment->lesson_id = $request->lesson_id;
        $attachment->file_link = $request->file_link;
        $attachment->file_link =asset('Attachments/'.$attachment->file_name. '/' . $attachment->file_name);
        $attachment->save();
        $file_link->move(public_path('Attachments/' . $attachment->file_name), $attachment->file_name);
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_attachment(Request $request){
        $request->validate([
            'file_name'    => 'required',
            'lesson_id'=> 'required',
            'file_link'=> 'required',
        ]);
        $file_link = $request->file('file_link');
        $link = $file_link->getClientOriginalName();

        $attachment=LessonAttachment::where('id',$request->id)->first();

        $attachment->file_name = $request->file_name;
        $attachment->lesson_id = $request->lesson_id;
        $attachment->file_link = $request->file_link;
        $attachment->file_link =asset('Attachments/'.$attachment->file_name. '/' . $attachment->file_name);
        $attachment->file_link =asset('Attachments/'.$attachment->file_name. '/' . $attachment->file_name);
        $attachment->save();
        $file_link->move(public_path('Attachments/' . $attachment->file_name), $attachment->file_name);
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_attachment(Request $request){
        $s=LessonAttachment::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }

}
