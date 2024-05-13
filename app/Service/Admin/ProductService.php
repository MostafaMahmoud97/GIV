<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\Product\IndexProductPaginateResource;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Inventroy;
use App\Models\Media;
use App\Models\Product;
use App\Models\Value;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductService
{
    use GeneralFileService;

    public function help_data(){
        $lang = LaravelLocalization::getCurrentLocale();
        $Categories = Category::select("id","parent_id","_lft","_rgt","title_".$lang." as title")->get()->toTree();

        $category_data = [];
        $traverse = function ($categories, $prefix ) use (&$traverse,&$category_data) {
            foreach ($categories as $category) {
                $category->title = $prefix.' '.$category->title;
                array_push($category_data,["id" => $category->id,"title" => $category->title]);

                $traverse($category->children, $prefix.'-');
            }
        };

        $traverse($Categories,"");

        $Attributes = Attribute::select("id","title_".$lang." as title")->with("Values")->get();

        $datax = [
            "categories" => $category_data,
            "attributes" => $Attributes
        ];

        return Response::successResponse($datax,"data has been fetched success");
    }

    public function index($request){
        $lang = LaravelLocalization::getCurrentLocale();
        $Products = Product::select("id","title_".$lang." as title","code","main_price_egy","main_price_usd","is_active")
        ->where(function ($q) use ($request,$lang){
            $q->where("title_".$lang,"like","%".$request->search."%")
                ->orWhere("code","like","%".$request->search."%");
        });

        if($request->is_active != "all"){
            $Products = $Products->where("is_active",$request->is_active);
        }

        $Products = $Products->paginate(10);

        return Response::successResponse(IndexProductPaginateResource::make($Products),"Products have been fetched success");
    }

    public function store($request){

        $Product = Product::create($request->all());

        $main_media_id = 0;
        if($request->media && $request->media != null){
            $flag_media = true;
            foreach ($request->media as $item){
                $path = "Product/";
                $file_name = $this->SaveFile($item,$path);
                $type = $this->getFileType($item);
                $media = Media::create([
                    'mediable_type' => $Product->getMorphClass(),
                    'mediable_id' => $Product->id,
                    'title' => "Product",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);

                if($flag_media){
                    $main_media_id = $media->id;
                    $flag_media = false;
                }

            }
        }

        if($request->category_ids && count($request->category_ids) > 0){
            $Product->Categories()->attach($request->category_ids);
        }

        if($request->attribute_ids && count($request->attribute_ids) > 0){
            $Product->Attributes()->attach($request->attribute_ids);
        }

        $this->storeInventory($request->variations,$Product->id,$main_media_id);

        return Response::successResponse($Product,"product has been created success");
    }

    private function storeInventory($Variations , $Product_id, $main_media_id){

        foreach ($Variations as $variation){
            $value1 = Value::find($variation["value_one_id"]);
            $value2 = Value::find($variation["value_two_id"]);
            $value3 = Value::find($variation["value_three_id"]);

            $value_title = "";

            if($value1){
                $value_title.= $value1->title;
            }

            if($value2){
                $value_title.= " / ".$value2->title;
            }

            if ($value3){
                $value_title.= " / ".$value3->title;
            }

            $data = [
                "product_id" => $Product_id,
                "value_one_id" => $variation["value_one_id"],
                "value_two_id" => $variation["value_two_id"],
                "value_three_id" => $variation["value_three_id"],
                "media_id" => $main_media_id,
                "value_title" => $value_title,
                "base_price_egy" => $variation["base_price_egy"],
                "price_instead_of_egy" => $variation["price_instead_of_egy"],
                "base_price_usd" => $variation["base_price_usd"],
                "price_instead_of_usd" => $variation["price_instead_of_usd"],
                "available" => $variation["available"],
            ];

            Inventroy::create($data);
        }
    }

    public function show($id){
        $Product = Product::with(["media","Categories","Inventory" => function($q){
            $q->with("media");
        }])->find($id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }

        return Response::successResponse($Product,"Product has been fetched success");
    }

    public function edit($id){
        $lang = LaravelLocalization::getCurrentLocale();

        $Product = Product::with(["media","Categories" => function($q) use ($lang){
            $q->select("categories.id","categories.title_".$lang." as title");
        },"Attributes" => function($q) use($lang){
            $q->select("attributes.id","attributes.title_".$lang." as title");
        },"Inventory"])->find($id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }


        return Response::successResponse($Product,"Product has been fetched success");
    }

    public function update_details($id,$request){
        $Product = Product::find($id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }

        $Product->update([
            "title_en" => $request->title_en,
            "title_ar" => $request->title_ar,
            "code" => $request->code,
            "description_ar" => $request->description_ar,
            "description_en" => $request->description_en,
        ]);

        if($request->category_ids && count($request->category_ids) > 0){
            $Product->Categories()->sync($request->category_ids);
        }

        return Response::successResponse([],"Product details has been updated success");
    }

    public function deleteImage($id){
        $Media = Media::find($id);
        if (!$Media){
            return Response::errorResponse("not found image");
        }

        $this->removeFile($Media->file_path);
        $Media->delete();
        return Response::successResponse([],"image has been deleted success");
    }

    public function addImages($request){
        $Product = Product::find($request->product_id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }

        if($request->media && $request->media != null){
            foreach ($request->media as $item){
                $path = "Product/";
                $file_name = $this->SaveFile($item,$path);
                $type = $this->getFileType($item);
                Media::create([
                    'mediable_type' => $Product->getMorphClass(),
                    'mediable_id' => $Product->id,
                    'title' => "Product",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);

            }
        }

        return Response::successResponse([],"Images have been created success");
    }

    public function update_pricing($id,$request){
        $Product = Product::find($id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }

        $Product->update([
            "main_price_egy" => $request->main_price_egy,
            "main_price_usd" => $request->main_price_usd,
            "main_instead_of_egy" => $request->main_instead_of_egy,
            "main_instead_of_usd" => $request->main_instead_of_usd,
        ]);

        return Response::successResponse([],"Product pricing has been updated success");
    }

    public function update_inventory($id,$request){
        $Product = Product::find($id);

        if (!$Product){
            return Response::errorResponse("not found product");
        }

        foreach ($request->inventory as $item){
            $inv = Inventroy::where("product_id",$id)->find($item["id"]);
            if (!$inv){
                return Response::errorResponse("not found variation with id : ".$item["id"]);
            }
            $inv->update([
                "base_price_egy" => $item["base_price_egy"],
                "price_instead_of_egy" => $item["price_instead_of_egy"],
                "base_price_usd" => $item["base_price_usd"],
                "price_instead_of_usd" => $item["price_instead_of_usd"],
            ]);
        }

        return Response::successResponse([],"variation has been fetched success");
    }

    public function change_status($id){
        $Product = Product::find($id);
        if (!$Product){
            return Response::errorResponse("not found product");
        }

        if($Product->is_active == 1){
            $Product->is_active = 0;
            $Product->save();
        }else{
            $Product->is_active = 1;
            $Product->save();
        }


        return Response::successResponse([],"status has been changed success");
    }
}
