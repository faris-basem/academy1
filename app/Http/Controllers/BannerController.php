<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function wellcom()
    {
        $w = DB::table('banners')->where('type', 'w')->get();
      
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status'=>true,
            'data'=>$w
        ]);
     
    }

    public function banner()
    {
        $b = DB::table('banners')->where('type', 'b')->get();
        if ($b->count() > 0) {

            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $b
            ]);
        } else {
            return response()->json([
                'message' => 'No Results',
                'code' => 500,
                'status' => false,
            ]);
        }
    }
    public function privacy()
    {
        $p = DB::table('banners')->where('type', 'p')->get();
        if ($p->count() > 0) {

            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $p
            ]);
        } else {
            return response()->json([
                'message' => 'No Results',
                'code' => 500,
                'status' => false,
            ]);
        }
    }
    public function about_us()
    {
        $a = DB::table('banners')->where('type', 'a')->get();
        if ($a->count() > 0) {
            return response()->json([
                'message' => 'Data Fetched Successfully',
                'code' => 200,
                'status' => true,
                'data' => $a
            ]);
        } else {
            return response()->json([
                'message' => 'No Results',
                'code' => 500,
                'status' => false,
            ]);
        }
    }

    public function articles()
    {
        $articles=Article::paginate(8);
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $articles
        ]);
    }
    public function article_by_id(Request $request)
    {
        $article=Article::where('id',$request->article_id)->first();
        $articles=Article::paginate(8);
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $article,
            'more' => $articles
        ]);
    }

    public function videoes_may_you_like()
    {
        $v=Video::paginate(6);
        return response()->json([
            'message' => 'Data Fetched Successfully',
            'code' => 200,
            'status' => true,
            'data' => $v
        ]);
    }
}
