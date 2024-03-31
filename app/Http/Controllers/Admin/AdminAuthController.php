<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AdminAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    protected $service;

    public function __construct(AdminAuthService $service){
        $this->service = $service;
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        if($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->login($request);
    }
}
