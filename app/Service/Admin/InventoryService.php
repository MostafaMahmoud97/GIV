<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\Inventory\IndexInventoryPagenateResource;
use App\Models\Inventroy;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InventoryService
{
    public function index($request){
        $lang = LaravelLocalization::getCurrentLocale();
        $Inventory = Inventroy::with(["media","Product" => function($q) use($lang){
            $q->select("id","title_".$lang." as title");
        }])->where("value_title","like","%".$request->search."%")
            ->OrWhereHas("Product",function ($q) use ($request,$lang){
                $q->where("title_".$lang,"like","%".$request->search."%");
            })->paginate(10);


        return Response::successResponse(IndexInventoryPagenateResource::make($Inventory),"Items have been fetched success");
    }

    public function getProductMedia($request){
        $Product = Product::find($request->product_id);
        if (!$Product){
            return Response::errorResponse("not found product");
        }

        $media = $Product->media;

        return Response::successResponse($media,"media has been fetched success");
    }

    public function change_image($id,$request){
        $Inventory = Inventroy::find($id);
        if (!$Inventory){
            return Response::errorResponse("not found item");
        }

        $Inventory->media_id = $request->media_id;
        $Inventory->save();
        return Response::successResponse([],"image has been changed success");
    }

    public function change_available($id,$request){
        $Inventory = Inventroy::find($id);
        if (!$Inventory){
            return Response::errorResponse("not found item");
        }

        $Inventory->available = $request->available;
        $Inventory->save();
        return Response::successResponse([],"Number available items has been changed success");
    }

    public function destroy($id){
        $Inventory = Inventroy::find($id);
        if (!$Inventory){
            return Response::errorResponse("not found item");
        }

        $Inventory->delete();
        return Response::successResponse($Inventory,"item has been deleted success");
    }
}
