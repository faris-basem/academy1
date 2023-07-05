<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SectionController extends Controller
{
    public function show_sections($course_id=null){
        if ($course_id==null){
         return view('sections.index');
        }else{
         return view('sections.index',compact('course_id'));
        }
     }
 
     public function get_sections_data($course_id=null)
     {
         if ($course_id==null){
             $data = Section::with('lessons')->orderBy('id')->get();
         }else{
             $data = Section::where('course_id',$course_id)->with('lessons')->orderBy('id')->get();
         }
         return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('course',function($data){
                 $s=Course::where('id',$data->course_id)->first();
                 return $s->name ?? "-";
             })
             ->addColumn('lessons',function($data){
                $s= $data->lessons->count();
                // return '<a href="'.route('course_sections').'"class="courses-link">'.$data->sections->count().'</a>';
                 return '<a href="'.route('show_lessons',$data->id).'" class="courses-link">'.$s.'</a>';
             })
             ->addColumn('action', function ($data) {
                 return view('sections.buttons.actions',compact('data'));
             })
             ->rawColumns(['lessons'])
 
             ->make(true);
     }



     public function store_section(Request $request){
        $request->validate([
            'name'   => 'required',
            'course_id'   => 'required',
        ]);
        
        $section=new Section();
        $section->name = $request->name;
        $section->course_id = $request->course_id;
        $section->save();        
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_section(Request $request){
        $request->validate([
            'name'    => 'required',
            'course_id'=> 'required',
        ]);
        $section=Section::where('id',$request->id)->first();

        $section->name = $request->name;
        $section->course_id = $request->course_id;
        $section->save();
            return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_section(Request $request){
        Section::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }
}
