<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);

        }
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->responseWithToken();
    }

//    public function register(SignupRequest $request)
//    {
//        dd('hi');
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'email' => 'required|email',
//            'password' => 'required',
//            'c_password' => 'required|same:password',
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['error'=>$validator->errors()], 401);
//        }
//        $input = $request->all();
//        $input['password'] = bcrypt($input['password']);
//        $user = User::create($input);
//        $success['token'] =  $user->createToken('MyApp')-> accessToken;
//        $success['name'] =  $user->name;
//        return response()->json(['success'=>$success], $this-> successStatus);
//    }
//
//    public function logout()
//    {
//        $this->guard()->logout();
//        return response()->json(['message' => 'User logged out successfully']);
//    }
//
//    public function profile()
//    {
//        return response()->json($this->guard()->user());
//    }
//
//    public function refresh()
//    {
//        return $this->responseWithToken();
//    }

    public function responseWithToken()
    {
        return response()->json([
            'access_token' => Str::random(100),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()->user_name
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }


}
