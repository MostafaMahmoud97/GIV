<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\GiftBox\IndexPaginateResource;
use App\Models\GiftBox;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GiftBoxService
{
    use GeneralFileService;

    public function index($request){
        $lang = LaravelLocalization::getCurrentLocale();
        $GiftBox = GiftBox::select("*","box_name_".$lang." as name")->where("box_name_en","like","%".$request->search."%")
            ->OrWhere("box_name_ar","like","%".$request->search."%")
            ->OrWhere("box_code","like","%".$request->search."%")->paginate(8);

        return Response::successResponse(IndexPaginateResource::make($GiftBox),__("admin/gift_box.Boxes have been fetched success"));
    }

    public function store($request){
        $GiftBox = GiftBox::create($request->all());

        if($request->media && count($request->media) > 0){
            $path = "GiftBox/";
            foreach ($request->media as $media){
                $file_name = $this->SaveFile($media,$path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $GiftBox->getMorphClass(),
                    'mediable_id' => $GiftBox->id,
                    'title' => "Gift Box",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        return Response::successResponse($GiftBox,__("admin/gift_box.box has been created success"));
    }

    public function show($id){
        $GiftBox = GiftBox::with("media")->find($id);
        if (!$GiftBox){
            return Response::errorResponse(__("admin/gift_box.not found gift box"));
        }

        return Response::successResponse($GiftBox,__("admin/gift_box.Gift box has been fetched success"));
    }

    public function update($id,$request){
        $GiftBox = GiftBox::find($id);
        if (!$GiftBox){
            return Response::errorResponse(__("admin/gift_box.not found gift box"));
        }

        $GiftBox->update($request->all());

        if($request->media && count($request->media) > 0){
            $GiftMedia = $GiftBox->media;
            foreach ($GiftMedia as $media){
                $media->delete();
            }

            $path = "GiftBox/";
            foreach ($request->media as $media){
                $file_name = $this->SaveFile($media,$path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $GiftBox->getMorphClass(),
                    'mediable_id' => $GiftBox->id,
                    'title' => "Gift Box",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        return Response::successResponse([],__("admin/gift_box.box has been updated success"));

    }

    public function ChangeStatus($id){
        $GiftBox = GiftBox::find($id);
        if (!$GiftBox){
            return Response::errorResponse(__("admin/gift_box.not found gift box"));
        }

        if($GiftBox->is_active == 1){
            $GiftBox->update([
                "is_active" => 0
            ]);
        }else{
            $GiftBox->update([
                "is_active" => 1
            ]);
        }

        return Response::successResponse([],__("admin/gift_box.status has been changed success"));
    }

    public function destroy($id){
        $GiftBox = GiftBox::find($id);
        if (!$GiftBox){
            return Response::errorResponse(__("admin/gift_box.not found gift box"));
        }

        $media = $GiftBox->media;
        foreach ($media as $item){
            $item->delete();
        }

        $GiftBox->delete();
        return Response::successResponse([],__("admin/gift_box.box has been deleted success"));
    }
}
