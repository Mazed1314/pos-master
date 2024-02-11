<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{


    public function authenticate(Request $request)
    // {


    //     // add UserStatus logic here if any

    //     if(Auth::attempt(['Email' => $request->email, 'Password' => $request->password], $request->remember)) 
    //     {

    //     $user = Auth::user();
    //     $success['token'] =  $request->user()->createToken('MyApp')->accessToken;
    //     return response()->json(['success' => $success], $this->successStatus);


    //     // $token = $user -> createToken('example')->accessToken;
    //     // return Response(['status'=> 200, 'token'=> $token],200);

    //     }
    //     return response()->json(['error'=>'Unauthorised'], 401);
    // }

     {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getUserDetail(): Response
    {
        

        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return Response(['data'=> $user],200);
        }
        return Response(['data'=> 'unauthenticated'],401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userLogout(): Response
    {

        if (Auth::guard('api')->check()){
            $accessToken = Auth::guard('api')->user()->token();

        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);
        $accessToken->revoked();

        return Response(['data'=> 'unauthenticated', 'message' => 'User Logout Successfully.'],200);
        }
        return Response(['data'=> 'unauthenticated'],401);
    }

   
}
