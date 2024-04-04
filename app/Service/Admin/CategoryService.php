<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\Category\IndexCategoryResource;
use App\Models\Category;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryService
{
    use GeneralFileService;

    public function index($request){
        $lang = LaravelLocalization::getCurrentLocale();

        $Categories = Category::select("id","parent_id","_lft","_rgt","code","title_".$lang." as title")
            ->where("title_".$lang,"like","%".$request->search."%")
            ->OrWhere("code","like","%".$request->search."%")
            ->with("media")->get()->toTree();

        $data = [];
        $traverse = function ($categories, $prefix ) use (&$traverse,&$data) {
            foreach ($categories as $category) {

                $category->title = $prefix.' '.$category->title;
                array_push($data,$category);

                $traverse($category->children, $prefix.'-');
            }
        };

        $traverse($Categories,"");

        return Response::successResponse(IndexCategoryResource::collection($data),__("admin/category.data has been fetched success"));
    }

    public function getHelpData(){
        $lang = LaravelLocalization::getCurrentLocale();
        $Category = Category::select("id","title_".$lang)->get();
        $data = [
            "category" => $Category
        ];
        return Response::successResponse($data,__("admin/category.data has been fetched success"));
    }

    public function store($request){
        $parent = null;
        if ($request->parent_id != 0 && $request->parent_id != null){
            $parent = Category::find($request->parent_id);
            if (!$parent){
                return Response::errorResponse(__("admin/category.not found parent"));
            }
        }

        $Category = Category::create($request->all(),$parent);

        if($request->media && $request->media != null){
            $path = "Category/";
            $file_name = $this->SaveFile($request->media,$path);
            $type = $this->getFileType($request->media);
            Media::create([
                'mediable_type' => $Category->getMorphClass(),
                'mediable_id' => $Category->id,
                'title' => "Category",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($Category,__("admin/category.Category has been created success"));
    }

    public function show($id){
        $Category = Category::with("media")->find($id);
        if (!$Category){
            return Response::errorResponse(__("admin/category.Not found category"));
        }

        return Response::successResponse($Category,__("admin/category.Category has been fetched success"));
    }

    public function update($id,$request){
        $Category = Category::find($id);
        if(!$Category){
            return Response::errorResponse(__("admin/category.Not found category"));
        }

        if ($Category->parent_id != $request->parent_id){
            $Category->parent_id = $request->parent_id;
            $Category->save();
            Category::fixTree();
        }

        $Category->update([
            "title_ar" => $request->title_ar,
            "title_en" => $request->title_en,
            "code" => $request->code
        ]);

        if ($request->media){
            $media = $Category->media;
            if ($media){
                $this->removeFile($media->file_path);
                $media->delete();
            }

            $path = "Category/";
            $file_name = $this->SaveFile($request->media,$path);
            $type = $this->getFileType($request->media);
            Media::create([
                'mediable_type' => $Category->getMorphClass(),
                'mediable_id' => $Category->id,
                'title' => "Category",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($Category,__("admin/category.category has been updated success"));
    }

    public function destroy($id){
        $Category = Category::find($id);
        if(!$Category){
            return Response::errorResponse(__("admin/category.Not found category"));
        }

        $media = $Category->media;
        if ($media){
            $this->removeFile($media->file_path);
            $media->delete();
        }

        $Category->delete();

        return Response::successResponse([],__("admin/category.category has been deleted success"));
    }


}
