<?php


namespace App\Service\Admin;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AdminAuthService
{
    public function login($request)
    {
        $user = $this->checkLogin($request->email,$request->password);
        if($user){
            auth('admin')->setUser($user);

            $token = Auth::guard('admin')->user()->createToken('passport_token')->accessToken;
            $user = Auth::guard('admin')->user();
            $success['user'] =  $user;
            $success['token'] =  $token;

            return Response::successResponse($success,__("admin/auth.User login successfully."));
        }
        else{
            return Response::errorResponse(__("admin/auth.Unauthorised."));
        }
    }

    private function checkLogin($email,$password){
        $user = Admin::where('email',$email)->first();
        if($user&&Hash::check($password, $user->password)){
            return $user;
        }else{
            return null;
        }
    }
}
