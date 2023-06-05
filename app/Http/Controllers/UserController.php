<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required|numeric|unique:users',
            'parent_phone'    => 'required|numeric',
            'password' => 'required|min:8',
            'level' => 'required',
            'study_type'=>'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'code' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }
        $user = new User();
        $user->name =  $request->name;
        $user->phone =  $request->phone;
        $user->parent_phone =  $request->parent_phone;
        $user->password =  bcrypt($request->password);
        $user->level =  $request->level;
        $user->study_type =  $request->study_type;
        $user->save();

        $user['token'] = $user->createToken('accessToken')->accessToken;

        return response()->json([
            'message' => 'user created successfully',
            'code' => 200,
            "status" => true,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'password' => 'required',
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

        $user = User::where('phone', $request->phone)->first();

        if($user){

            if (!Hash::check($request->password, $user->password)) {

                return response()->json(
                    [
                        "errors" => [
                            "password" => [
                                "Invalid Password!"
                            ]
                        ],
                        "status" => false,
                        'code' => 404,
                    ]
                );
            }

            $accessToken =     $user->createToken('authToken')->accessToken;

            return response([
                'code' => 200,
                'status' => true,
                'message' => 'login Successfully',
                'user' => $user,
                'access_token' => $accessToken
            ]);
        }else{
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

    public function logout()
    {
        $user = Auth::guard('api')->user()->token();
        $user->revoke();
        return response()->json([
            'code' => 200,
            "status" => true,
            'message' => 'logout Successfully',

        ]);
    }

    public function verify(Request $request)
    {
        $verify= new Verify();
        $verify->user_id=Auth::guard('api')->user()->id;
        $verify->name=$request->name;
        $verify->governorate=$request->governorate;
        $verify->address=$request->address;

        $pfp=$request->file('profile_picture');
        $frontp=$request->file('front_pic');
        $backp=$request->file('back_pic');

        $pfp_name=$pfp->getClientOriginalName();
        $frontp_name=$frontp->getClientOriginalName();
        $backp_name=$backp->getClientOriginalName();

        $verify->profile_picture=asset('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id . '/' . $pfp_name);
        $verify->front_pic=asset('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id . '/' . $frontp_name);
        $verify->back_pic=asset('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id . '/' . $backp_name);
        $verify->save();

        $pfp->move(public_path('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id), $pfp_name);
        $frontp->move(public_path('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id), $frontp_name);
        $backp->move(public_path('Attachments/Verify_Attachments/' . Auth::guard('api')->user()->id), $backp_name);

        return response()->json([
            'message' => 'Request Sent Successfully',
            'code' => 200,
            'status' => true,
        ]);

    }

    public function forgot(Request $request)
    {
        $ran = Str::random(6);
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $user->code = $ran;
            $user->save();
            return response()->json([
                'code' => 200,
                "status" => true,
                'data' => $ran,
            ]);
        } else {
            return response()->json(
                [
                    "errors" => [
                        "phone" => [ "No Account Assigned To This Phone !"]
                    ],
                    "status" => false,
                    'code' => 404,
                ]
            );
        }
    }

    public function chang_pass(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->code == $request->code) {
                $user->password = bcrypt($request->new_password);
                $user->code = null;
                $user->save();
                return response()->json([
                    'code' => 200,
                    "status" => true,
                    'message' => 'your password is updated successfully',
                    'data' => $user,

                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'This code is invalid',
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'No Account Assigned To This Phone !',
            ]);
        }
    }
}
