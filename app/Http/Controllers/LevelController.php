<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LevelController extends Controller
{
    public function show_levels($subject_id=null){
       if ($subject_id==null){
        return view('levels.index');
       }else{
        return view('levels.index',compact('subject_id'));
       }
    }

    public function get_levels_data($subject_id=null)
    {
        if ($subject_id==null){
            $data = Level::with('courses')->orderBy('id')->get();
        }else{
            $data = Level::where('subject_id',$subject_id)->with('courses')->orderBy('id')->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('subject',function($data){
                $s=Subject::where('id',$data->subject_id)->first();
                return $s->name ?? "-";
            })
            ->addColumn('courses',function($data){
                $count_courses = Course::where('level_id',$data->id)->count();
                // return '<a href="'.route('level_courses').'"class="levels-link">'.$count_courses.'</a>';
                return '<a href="'.route('show_courses',$data->id).'"class="levels-link">'.$count_courses.'</a>';
            })
            ->addColumn('action', function ($data) {
                return view('levels.buttons.actions',compact('data'));
            })
            ->rawColumns(['courses'])

            ->make(true);
    }

    public function store_level(Request $request){
        $request->validate([
            'name'   => 'required',
        ]);
        $level=new Level();
        $level->name = $request->name;
        $level->subject_id = $request->subject_id;
        $level->save();        
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_level(Request $request){
        $request->validate([
            'name'   => 'required',
        ]);
        $level=Level::where('id',$request->id)->first();
        $level->name=$request->name;
        $level->subject_id=$request->subject_id;
        $level->save();        
        return response()->json([
            'message'=>'edited success'
        ]);
    }

    public function delete_level(Request $request){
        $s=Level::where('id',$request->id)->delete();
        return response()->json([
            'message'=>'deleted successfully'
        ]);
    }
}
