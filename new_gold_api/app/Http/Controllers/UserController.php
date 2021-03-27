<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {

//        $user = User::create([
//            'email'    => $request->email,
//            'password' => $request->password,
//            'user_name' => $request->name,
//            'user_type_id' => $request->user_type_id
//        ]);
        $user = User::create([
            'email'    => $request->email,
            'password' => $request->password,
            'person_id' => $request->person_id,
//            'user_type_id' => $request->user_type_id
        ]);

//        return response()->json(['success'=>1,'data'=>$user], 200,[],JSON_NUMERIC_CHECK);

        $token = $user->createToken('my-app-token')->plainTextToken;

//        $response = [
//            'user' => $user,
//            'token' => $token
//        ];
//        return response($response, 201);
        return response()->json(['success'=>1,'user'=>$user, 'token'=>$token ,'message'=>'Welcome'], 200,[],JSON_NUMERIC_CHECK);
    }

    function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();
//        return response()->json(['message'=>$user], 200,[],JSON_NUMERIC_CHECK);
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success'=>0,'data'=>null, 'message'=>'Credential does not matched'], 200,[],JSON_NUMERIC_CHECK);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
//        $token2 = $user->session()->token();

//        $token2 = csrf_token();
        $data = Person::find($user->person_id)->userData;
//        $response = [
//            'user' => $user,
//            'token' => $token
//        ];
//        return response()->json(['success'=>1,'data'=>$response, 'message'=>'Welcome'], 200,[],JSON_NUMERIC_CHECK);
        return response()->json(['success'=>1,'user'=>$data,'token'=>$token ,'message'=>'Welcome'], 200,[],JSON_NUMERIC_CHECK);
    }


    function getCurrentUser(Request $request){
        return $request->user();
//        return User::get();

    }

    function getAllUsers(Request $request){
        return User::get();
    }
    function logout(Request $request){
        $result = $request->user()->currentAccessToken()->delete();
        return $result;
    }

    function testPic(Request $request){
        $input = json_decode($request->getContent(), true);


        $fileName = $request['filename'];
//        $fileName = 'test1.jpeg';
//        return $fileName;
        //first saving picture

        //return $fileName;
        $path = $request->file('file')->move(public_path("/profile_pic"), $fileName);
        $photoUrl = url('/entrant_pictures/' . $fileName);

        return response()->json(['success'=>100,'data'=> $input], 200,[],JSON_NUMERIC_CHECK);

    }


}
