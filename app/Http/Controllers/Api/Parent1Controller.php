<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Parent1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Parent1Controller extends Controller
{
    public function parent_login(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'parent_phone' => 'required|numeric',
        ]);

        if ($loginData->fails()) {
            $errors = $loginData->errors();

            return response([
                'status' => false,
                'message' => 'Make sure that the information is correct and fill in all fields',
                'errors' => $errors,
                'code' => 422
            ]);
        }

        $user = User::where('phone', $request->phone)->where('parent_phone', $request->parent_phone)->first();
        $user1 = Parent1::where('std_phone', $request->phone)->first();

        if ($user && $user1) {
            if ($user->phone == $user1->std_phone && $user->parent_phone == $user1->phone) {
                $accessToken = $user1->createToken('ParentAuthToken')->accessToken;

                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'login Successfully',
                    'user' => $user1,
                    'access_token' => $accessToken
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Make sure that the information is correct',
                    'code' => 422
                ]);
            }
        } else if ($user) {
            if($user->parent_phone==$request->phone){
                $p = new Parent1;
                $p->phone = $user->parent_phone;
                $p->std_phone = $user->phone;
                $p->save();
                $accessToken = $p->createToken('ParentAuthToken')->accessToken;
    
                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'login Successfully',
                    'user' => $p,
                    'access_token' => $accessToken
                ]);
            }else {
                return response([
                    'status' => false,
                    'message' => 'Make sure that the information is correct',
                    'code' => 422
                ]);
            }
        } else {
            return response()->json(
                [
                    "errors" => [
                        "phone" => [
                            "No Account Assigned To This Phone !"
                        ]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }
    public function parent_logout()
    {
        $user = Auth::guard('parent')->user()->token();
        $user->revoke();
        return response()->json([
            'code' => 200,
            "status" => true,
            'message' => 'logout Successfully',

        ]);
    }
}
