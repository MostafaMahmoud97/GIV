<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Service\Api\AuthUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    protected $service;

    public function __construct(AuthUserService $service)
    {
        $this->service = $service;
    }

    public function helpData(){
        return $this->service->helpData();
    }

    public function register(Request $request){
        return $this->service->register($request);
    }

    public function verifyEmail(Request $request){
        $validator = Validator::make($request->all(),[
            "user_id" => "required|exists:users,id"
        ]);
        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->VerifyEmail($request);
    }

    public function resendVerifyEmail(){
        return $this->service->resendVerifyEmail();
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:8"
        ]);
        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->login($request);
    }

    public function forgot_password(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);

        if($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return  $this->service->forgot_password($request);
    }

    public function callback_reset_password(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required',
        ]);

        if($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        $this->service->callback_reset($request);
    }

    public function reset_password(Request $request){
        return $this->service->reset_password($request);
    }
}
