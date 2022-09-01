<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyApi')->plainTextToken;
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'User Logged In');
        }else{
            return $this->sendError('Unauthorized.', ['error' => 'Wrong credentials'], 403);
        }
    }

    public function signup(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('MyApi')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'Registration Successful');
        }
    }
}
