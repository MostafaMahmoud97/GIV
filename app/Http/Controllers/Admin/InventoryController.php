<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventroy;
use App\Service\Admin\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    protected $service;

    public function __construct(InventoryService $service){
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function getProductMedia(Request $request){
        return $this->service->getProductMedia($request);
    }

    public function change_image($id,Request $request){
        $validator = Validator::make($request->all(),[
            "media_id" => "required|integer|exists:media,id"
        ]);
        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->change_image($id,$request);
    }

    public function change_available($id,Request $request){
        $validator = Validator::make($request->all(),[
            "available" => "required|integer|gt:-1"
        ]);
        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->change_available($id,$request);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
}
