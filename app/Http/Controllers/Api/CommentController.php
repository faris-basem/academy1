<?php

namespace App\Http\Controllers\Api;

use App\Models\Replie;
use App\Models\Comment;
use App\Models\Commetlike;
use App\Models\ReplieLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function add_comment(Request $request)
    {
        $comment=new Comment();
        $comment->lesson_id=$request->lesson_id;
        $comment->comment=$request->comment;
        $comment->user_id=Auth::guard('api')->user()->id;
        $comment->save();
        return response()->json([
            'message' => 'Comment Added Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$comment
        ]);
    }
    public function add_replie(Request $request)
    {
        $replie=new Replie();
        $replie->comment_id=$request->comment_id;
        $replie->replie=$request->replie;
        $replie->user_id=Auth::guard('api')->user()->id;
        $replie->save();
        return response()->json([
            'message' => 'Replie Added Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$replie
        ]);
    }

    public function replies(Request $request)
    {
        $replies=Replie::where('comment_id',$request->comment_id)->get();
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$replies
        ]);
    }

    public function add_like_comment(Request $request)
    {
        $is_like=Commetlike::where('user_id',Auth::guard('api')->user()->id)->where('comment_id',$request->comment_id)->first();
        if($is_like){
            $comment=Comment::where('id',$request->comment_id)->first();
            $comment->likes_count--;
            $comment->save();
            $is_like->delete();
            return response()->json([
                'code' => 200,
                'data' => 'Like Removed',
                'status'=>true,
            ]);

        }else{
            $like=new Commetlike();
            $like->comment_id=$request->comment_id;
            $like->user_id=Auth::guard('api')->user()->id;
            $like->save();
            $comment=Comment::where('id',$request->comment_id)->first();
            $comment->likes_count++;
            $comment->save();
            return response()->json([
                'code' => 200,
                'data' => 'Like Added',
                'status'=>true,
            ]);
        }
    }
    public function add_like_replie(Request $request)
    {
        $is_like=ReplieLike::where('user_id',Auth::guard('api')->user()->id)->where('replie_id',$request->replie_id)->first();
        if($is_like){
            $replie=Replie::where('id',$request->replie_id)->first();
            $replie->likes_count--;
            $replie->save();
            $is_like->delete();
            return response()->json([
                'code' => 200,
                'data' => 'Like Removed',
                'status'=>true,
            ]);
        }else{
            $like=new ReplieLike();
            $like->user_id=Auth::guard('api')->user()->id;
            $like->replie_id=$request->replie_id;
            $like->save();
            $replie=Replie::where('id',$request->replie_id)->first();
            $replie->likes_count++;
            $replie->save();
            return response()->json([
                'code' => 200,
                'data' => 'Like Added',
                'status'=>true,
            ]);
        }
    }

}
