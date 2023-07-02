<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    public function show_subjects(){
        return view('subjects.index');
    }
    public function get_subjects_data()
    {
        $subjects = Subject::with('levels')->orderBy('id')->get();

        return DataTables::of($subjects)
            ->addIndexColumn()
            ->addColumn('levels',function($subjects){
                $l=$subjects->levels->count();
                return '<a href="'.route('show_levels',$subjects->id).'"class="levels-link">'.$l.'</a>';
            })
            ->addColumn('action', function ($subjects) {
                return view('subjects.buttons.actions',compact('subjects'));
            })
            ->rawColumns(['levels'])

            ->make(true);
    }

    public function store_subject(Request $request){
        $request->validate([
            'name'   => 'required',
        ]);
        $subject=new Subject();
        $subject->name = $request->name;
        $subject->save();        
        return response()->json([
            'message'=>'add success'
        ]);
    }

    public function edit_subject(Request $request){
        $request->validate([
            'name'   => 'required',
        ]);
        $sub=Subject::where('id',$request->id)->first();
        $sub->name=$request->name;
        $sub->save();        
        return response()->json([
            'message'=>'edited success'
        ]);

    }

    public function delete_subject(Request $request){
        $s=Subject::where('id',$request->id)->delete();
        return response()->json(['message'=>'deleted successfully']);
    }

}
