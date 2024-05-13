<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductDetailsRequest;
use App\Service\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service){
        $this->service = $service;
    }

    public function help_data(){
        return $this->service->help_data();
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function store(StoreProductRequest $request){
        return $this->service->store($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function edit($id){
        return $this->service->edit($id);
    }

    public function update_details($id,UpdateProductDetailsRequest $request){
        return $this->service->update_details($id,$request);
    }

    public function deleteImage($id){
        return $this->service->deleteImage($id);
    }

    public function addImages(Request $request){
        $validator = Validator::make($request->all(),[
            "product_id" => "required|exists:products,id",
            "media" => "required|array|min:1",
            "media.*" => "mimes:jpg,png,jpeg,svg,webp"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->addImages($request);
    }

    public function update_pricing($id,Request $request){
        $validator = Validator::make($request->all(),[
            "main_price_egy" => "required|numeric",
            "main_instead_of_egy" => "numeric|nullable",
            "main_price_usd" => "required|numeric",
            "main_instead_of_usd" => "numeric|nullable",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update_pricing($id,$request);
    }

    public function update_inventory($id,Request $request){
        $validator = Validator::make($request->all(),[
            "inventory" => "required|array|min:1",
            "inventory.*.id" => "required|exists:inventroys,id",
            "inventory.*.base_price_egy" => "required|numeric",
            "inventory.*.price_instead_of_egy" => "numeric|nullable",
            "inventory.*.base_price_usd" => "required|numeric",
            "inventory.*.price_instead_of_usd" => "numeric|nullable",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update_inventory($id,$request);
    }

    public function change_status($id){
        return $this->service->change_status($id);
    }
}
