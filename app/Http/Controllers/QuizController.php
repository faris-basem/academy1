<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\MyQuiz;
use App\Models\Question;
use App\Models\Section;
use App\Models\StudentPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function quiz_details(Request $request)
    {
        $mq = MyQuiz::where('user_id', Auth::guard('api')->user()->id)->where('quiz_id', $request->quiz_id)->first();
        $quiz = Quiz::where('id', $request->quiz_id)->first();
        if ($mq) {
            $quiz['remaining_attempts'] = $mq->attempts;
            $quiz['your_points'] = $mq->points;
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $quiz
            ]);
        } else {
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $quiz
            ]);
        }
    }

    public function start_quiz(Request $request)
    {
        $mq = MyQuiz::where('user_id', Auth::guard('api')->user()->id)->where('quiz_id', $request->quiz_id)->first();
        $quiz = Quiz::where('id', $request->quiz_id)->with('questions.answers')->first();
        $less = Lesson::where('id', $quiz->lesson_id)->first();
        $sec = Section::where('id', $less->section_id)->first();
        $std_points = StudentPoint::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $sec->course_id)->first();

        if ($mq) {
            if ($mq->attempts > 0) {
                $std_points->points = $std_points->points - $mq->points;
                $std_points->save();
                $mq->points = 0;
                $mq->attempts--;
                $mq->save();
                return response()->json([
                    'message' => 'Data Fetched Successfully',
                    'code' => 200,
                    'status' => true,
                    'data' => $quiz
                ]);
            } else {
                return response()->json([
                    'message' => 'you dont have more attempts',
                    'code' => 400,
                    'status' => false,
                ]);
            }
        } else {
            $new_quiz = new MyQuiz;
            $new_quiz->user_id = Auth::guard('api')->user()->id;
            $new_quiz->quiz_id = $request->quiz_id;
            $new_quiz->attempts = $quiz->attempts;
            $new_quiz->points = 0;
            $new_quiz->save();

            if (!$std_points) {
                $new_std = new StudentPoint();
                $new_std->points = $new_quiz->points;
                $new_std->user_id = Auth::guard('api')->user()->id;
                $new_std->course_id = $sec->course_id;
                $new_std->save();
            }
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $quiz
            ]);
        }
    }

    public function end_quiz(Request $request)
    {
        $mq = MyQuiz::where('user_id', Auth::guard('api')->user()->id)->where('quiz_id', $request->quiz_id)->first();
        $quiz = Quiz::where('id', $request->quiz_id)->first();
        $questions = Question::where('quiz_id', $request->quiz_id)->pluck('id');
        $answers = Answer::whereIn('question_id', $questions)->get();
        $less = Lesson::where('id', $quiz->lesson_id)->first();
        $sec = Section::where('id', $less->section_id)->first();

        $arrayData = json_decode($request->answers, true);
        $trueans = 0;
        foreach ($arrayData as $item) {
            $answerId = $item['answer_id'];
            $answerItem = $answers->where('id', $answerId)->first();
            if ($answerItem->status == 1) {
                $trueans++;
            }
        }
        $points_for_ans = $quiz->points / $questions->count();

        $std_points = StudentPoint::where('user_id', Auth::guard('api')->user()->id)->where('course_id', $sec->course_id)->first();

        if ($quiz->attempts == $mq->attempts) {
            $mq->points = $points_for_ans * $trueans;
            $mq->save();
            $std_points->points = $std_points->points + $mq->points;
            $std_points->save();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $mq
            ]);
        } else {
            $attempts_count = $quiz->attempts - $mq->attempts;
            $deduction = $attempts_count * $quiz->deduction_per_attempt;
            $yourpoints = $points_for_ans * $trueans;
            $finalpoints = $yourpoints - $deduction;
            $mq->points = $finalpoints;
            $mq->save();
            $std_points->points = $std_points->points + $mq->points;
            $std_points->save();
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $mq
            ]);
        }
    }
}
