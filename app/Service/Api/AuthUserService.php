<?php


namespace App\Service\Api;


use App\Models\Country;
use App\Models\User;
use App\Notifications\VerifyEmailNtoify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class AuthUserService
{
    protected $base_url;

    public function __construct()
    {
        $status = 'sandbox';
        $this->base_url = config("app_service.".$status)["base_url"];
    }

    public function helpData(){
        $Countries = Country::select("id","name","phone_code")->get();
        return Response::successResponse($Countries,"Countries have been fetched success");
    }

    public function register($request){
        $User = User::create([
            'country_id' => $request->country_id,
            'name' => $request->name,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $success['token'] =  $User->createToken('passport_token')->accessToken;
        $success['user'] =  $User;

        $url = $this->base_url."/api/auth/call-back-verify?user_id=".$User->id;
        Notification::send($User,new VerifyEmailNtoify($url,$User->name));

        return Response::successResponse($success,"user has been registered success");

    }

    public function VerifyEmail($request){
        $user = User::find($request->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        //return redirect()->to('https://octar.adgrouptech.com/new-password?success=email has been verified success');
        return Response::successResponse([],"email has been verified success");
    }

    public function resendVerifyEmail(){
        $user = Auth::user();
        $url = $this->base_url."/api/auth/call-back-verify?user_id=".$user->id;

        Notification::send($user,new VerifyEmailNtoify($url,$user->name));

        return Response::successResponse([],"sent succesfully");
    }

    public function login($request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            if ($user->is_active == 0){
                return Response::errorResponse("This account has been suspended");
            }

            $success['token'] =  $user->createToken('passport_token')-> accessToken;
            $success['user'] =  $user;



            return Response::successResponse($success,"User login successfully.");
        }
        else{
            return Response::errorResponse("Unauthorised");
        }
    }


    public function forgot_password($request){

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return Response::successResponse([],$status);
        }

        if ($status == Password::RESET_THROTTLED){
            return Response::errorResponse('reset message is sent to mail');
        }elseif ($status == Password::INVALID_USER){
            return Response::errorResponse('this user not found');
        }

        return Response::errorResponse($status);
    }

    public function callback_reset($request){
        return $request->all();
        //return redirect()->to('https://octar.adgrouptech.com/new-password?token='.$request->token."&email=".$request->email);
    }

    public function reset_password($request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user) use ($request){
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET){
            return Response::successResponse([],"password reset successfully");
        }

        return Response::errorResponse($status,[],500);
    }
}
