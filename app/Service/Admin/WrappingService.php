<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\Wrapping\IndexPaginateResource;
use App\Models\Media;
use App\Models\Wrapping;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WrappingService
{
    use GeneralFileService;

    public function index($request){
        $lang = LaravelLocalization::getCurrentLocale();
        $Wrapping = Wrapping::select("*","title_".$lang." as title")->where("title_".$lang,"like","%".$request->search."%")
            ->OrWhere("code","like","%".$request->search."%")->paginate(8);

        return Response::successResponse(IndexPaginateResource::make($Wrapping),__("admin/wrapping.Wrapping has been fetched success"));
    }

    public function store($request){
        $Wrapping = Wrapping::create($request->all());

        if($request->media && count($request->media) > 0){
            $path = "Wrapping/";
            foreach ($request->media as $media){
                $file_name = $this->SaveFile($media,$path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $Wrapping->getMorphClass(),
                    'mediable_id' => $Wrapping->id,
                    'title' => "Wrapping",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        return Response::successResponse($Wrapping,__("admin/wrapping.wrapping has been created success"));
    }

    public function show($id){
        $Wrapping = Wrapping::with("media")->find($id);
        if (!$Wrapping){
            return Response::errorResponse(__("admin/wrapping.not found wrapping"));
        }

        return Response::successResponse($Wrapping,__("admin/wrapping.Wrapping has been fetched success"));
    }

    public function update($id,$request){
        $Wrapping = Wrapping::find($id);
        if (!$Wrapping){
            return Response::errorResponse(__("admin/wrapping.not found wrapping"));
        }

        $Wrapping->update($request->all());

        if($request->media && count($request->media) > 0){
            $WrappingMedia = $Wrapping->media;
            foreach ($WrappingMedia as $media){
                $media->delete();
            }

            $path = "Wrapping/";
            foreach ($request->media as $media){
                $file_name = $this->SaveFile($media,$path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $Wrapping->getMorphClass(),
                    'mediable_id' => $Wrapping->id,
                    'title' => "Wrapping",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        return Response::successResponse([],__("admin/wrapping.Wrapping has been updated success"));

    }

    public function ChangeStatus($id){
        $Wrapping = Wrapping::find($id);
        if (!$Wrapping){
            return Response::errorResponse(__("admin/wrapping.not found wrapping"));
        }

        if($Wrapping->is_active == 1){
            $Wrapping->update([
                "is_active" => 0
            ]);
        }else{
            $Wrapping->update([
                "is_active" => 1
            ]);
        }

        return Response::successResponse([],__("admin/wrapping.status has been changed success"));
    }

    public function destroy($id){
        $Wrapping = Wrapping::find($id);
        if (!$Wrapping){
            return Response::errorResponse(__("admin/wrapping.not found wrapping"));
        }

        $media = $Wrapping->media;
        foreach ($media as $item){
            $item->delete();
        }

        $Wrapping->delete();
        return Response::successResponse([],__("admin/wrapping.Wrapping has been deleted success"));
    }
}
