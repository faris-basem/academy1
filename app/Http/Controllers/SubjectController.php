<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    public function show_subjects(){
        return view('show_subjects');
    }
    public function get_subjects_data()
    {
        $subjects = Subject::with('levels')->orderBy('id')->get();

        return DataTables::of($subjects)
            ->addIndexColumn()
            ->addColumn('levels',function($subjects){
                return $subjects->levels->count();
            })
            ->addColumn('action', function ($subjects) {
                return view('buttons.actions',compact('subjects'));
            })
            ->toJson();
    }
    public function store_subject(Request $request){
        $request->validate([
            'name'   => 'required',
        ]);
        $subject=new Subject();
        $subject->name = $request->name;
        $subject->save();        
        return response()->json([]);
    }
    public function delete_subject(Request $request){
        $s=Subject::where('id',$request->id)->delete();
        return response()->json(['message'=>'deleted successfully']);
    }
    public function subject_levels($id){
        $lev=Level::where('subject_id',$id)->get();
        return view('subject_levels',compact('lev'));
    }
}
