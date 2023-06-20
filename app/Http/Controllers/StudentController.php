<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\StudentAttendance;
use App\Models\StudentDegree;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function my_group()
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {
            $std = StudentGroup::Where('user_id', Auth::guard('api')->user()->id)->first();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $std
            ]);
        } else {
            return response()->json([
                'message' => 'You Are Online',
                'code' => 400,
                'status' => false,
            ]);
        }
    }

    public function my_exams()
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {
            $exam = StudentDegree::Where('user_id', Auth::guard('api')->user()->id)->get();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $exam
            ]);
        } else {
            return response()->json([
                'message' => 'You Are Online',
                'code' => 400,
                'status' => false,
            ]);
        }
    }

    public function my_lectures()
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {
            $attendance = StudentAttendance::Where('user_id', Auth::guard('api')->user()->id)->with('lectures')->get();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $attendance
            ]);
        } else {
            return response()->json([
                'message' => 'You Are Online',
                'code' => 400,
                'status' => false,
            ]);
        }
    }

    public function installments()
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {
            $installments = Installment::where('user_id', Auth::guard('api')->user()->id)->get();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $installments
            ]);
        } else {
            return response()->json([
                'message' => 'You Are Online',
                'code' => 400,
                'status' => false,
            ]);
        }
    }

    public function std_performance(Request $request)
    {
        if (Auth::guard('api')->user()->study_type == 'حضوري') {
            $attendance = StudentAttendance::Where('user_id', Auth::guard('api')->user()->id)->get();
            $exam = StudentDegree::Where('user_id', Auth::guard('api')->user()->id)->get();
            $installments = Installment::where('user_id', Auth::guard('api')->user()->id)->orderBy('created_at', 'desc')->first();
            $attend['lectures'] = $attendance->count();
            $attend['presence'] = $attendance->where('status', 'حضور')->count();
            $attend['absence'] = $attendance->where('status', 'غياب')->count();
            $attend['vacation'] = $attendance->where('status', 'اجازة')->count();
            $ex['exams'] = $exam->count();
            $ex['success'] = $exam->where('status', 'ناجح')->count();
            $ex['failing'] = $exam->where('status', 'راسب')->count();
            $ex['absence'] = $exam->where('status', 'غياب')->count();
            $inst['all'] = $installments->deserved;
            $inst['paid'] = strval($installments->deserved - $installments->remain);
            $inst['remains'] = $installments->remain;


            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'attendance' => $attend,
                'exams' => $ex,
                'installments' => $inst,
            ]);
        } else {
            return response()->json([
                'message' => 'You Are Online',
                'code' => 400,
                'status' => false,
            ]);
        }
    }
}
