<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    protected $service;

    public function __construct(AttributeService $service){
        $this->service = $service;
    }

    public function indexAttributes(){
        return $this->service->indexAttributes();
    }

    public function storeAttribute(Request $request){
        $Validator = Validator::make($request->all(),[
            "title" => "required|string",
            "values" => "required|string"
        ]);
        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return $this->service->storeAttribute($request);
    }

    public function showAttribute($id){
        return $this->service->showAttribute($id);
    }

    public function updateAttribute($id,Request $request){
        $Validator = Validator::make($request->all(),[
            "title" => "required|string"
        ]);
        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return $this->service->updateAttribute($id,$request);
    }

    public function destroyAttribute($id){
        return $this->service->destroyAttribute($id);
    }

    public function storeValue(Request $request){
        $Validator = Validator::make($request->all(),[
            "attribute_id" => "required|integer|exists:attributes,id",
            "title" => "required|string"
        ]);
        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }
        return $this->service->storeValue($request);
    }

    public function updateValue($id,Request $request){
        $Validator = Validator::make($request->all(),[
            "title" => "required|string"
        ]);
        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }
        return $this->service->updateValue($id,$request);
    }

    public function destroyValue($id){
        return $this->service->destroyValue($id);
    }
}
