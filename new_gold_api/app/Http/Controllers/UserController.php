<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends APIController
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
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['success'=>0,'data'=>null, 'message'=>'Credential does not matched'], 200,[],JSON_NUMERIC_CHECK);
        } elseif (!$user) {
            return response()->json(['success' => 0, 'data' => null, 'message' => 'Credential does not matched'], 200, [], JSON_NUMERIC_CHECK);
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
    }

    function getBearerToken(Request $request){
        return $request->bearerToken();
    }

    function actualToken(Request $request){
        return  request()->user()->currentAccessToken()->token;
    }
    function getUserHistory(Request $request){
        $token = request()->user()->currentAccessToken()->token;

        $result = DB::table('personal_access_tokens')
            ->select('users.id','email','user_name','user_type_name','mobile1','abilities','personal_access_tokens.last_used_at','personal_access_tokens.created_at','personal_access_tokens.updated_at')
            ->join('users','users.id','=','personal_access_tokens.tokenable_id')
            ->join('people','people.id','=','users.person_id')
            ->join('user_types','user_types.id','=','people.user_type_id')
            ->where('personal_access_tokens.token','=',$token)->first();
        return $result;
    }

    function getAllUsers(Request $request){
        return User::get();
    }
    function logout(Request $request){
        $result = $request->user()->currentAccessToken()->delete();
        return $result;
    }
    public function revoke_all(Request $request){
        //revoke all tokens from current user
        $user = request()->user();
        $result = $user->tokens()->delete();
        return $this->successResponse($result);
    }

    function uploadPicture(Request $request){
//        $input = json_decode($request->getContent(), true);


        $fileName = $request['filename'];
//        $fileName = 'test1.jpeg';
//        return $fileName;
        //first saving picture

        //return $fileName;
        $path = $request->file('file')->move(public_path("/profile_pic"), $fileName);
//        $photoUrl = url('/entrant_pictures/' . $fileName);

        return response()->json(['success'=>100,'data'=> $path], 200,[],JSON_NUMERIC_CHECK);

    }

    public function getEmployees(){
        $employees = Person::select('people.id','people.user_name')
                      ->join('users','users.person_id','=','people.id')
                      ->get();

        return response()->json(['success'=>1,'data'=> $employees], 200,[],JSON_NUMERIC_CHECK);
    }
    public function resetPassword(Request $request){
        $user = User::select()->where('person_id',$request->id)->first();
        $user->password = $request->input('changedPassword');
        $user->update();
        return response()->json(['success'=>1,'data'=> $user], 200,[],JSON_NUMERIC_CHECK);
    }

    public function updatePassword(Request $request){
        $input = $request->all();
        $userid=$request->user()->id;

        $rules = array(
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirm_password' => 'required|same:newPassword',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(),400);
        }
        try {
            if ((Hash::check(request('oldPassword'), Auth::user()->password)) == false) {
                return $this->errorResponse("Check your old password.",400);
            } else if ((Hash::check(request('newPassword'), Auth::user()->password)) == true) {
                return $this->errorResponse("Please enter a password which is not similar then current password.",400);
            } else {
                User::where('id', $userid)->update(['password' => Hash::make($input['newPassword'])]);
                return $this->successResponse(array(),"Password updated successfully.");
            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            return $this->errorResponse($msg,400);
        }
    }

}
