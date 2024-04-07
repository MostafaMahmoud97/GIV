<?php


namespace App\Service\Admin;


use App\Models\Media;
use App\Models\Store;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class StoreService
{
    use GeneralFileService;

    public function index($request){
        $Stores = Store::with("media")
            ->where("name","like","%".$request->search."%")
            ->OrWhere("email","like","%".$request->search."%")
            ->paginate(10);

        return Response::successResponse($Stores,__("admin/store.data has been fetched success"));
    }

    public function store($request){
        $Store = Store::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        if($request->media && $request->media != null){
            $path = "Store/";
            $file_name = $this->SaveFile($request->media,$path);
            $type = $this->getFileType($request->media);
            Media::create([
                'mediable_type' => $Store->getMorphClass(),
                'mediable_id' => $Store->id,
                'title' => "Store Logo",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($Store, __("admin/store.Store has been created success"));
    }

    public function show($id){
        $Store = Store::with("media")->find($id);
        if (!$Store){
            return Response::errorResponse(__("admin/store.not found store"));
        }

        return Response::successResponse($Store,__("admin/store.data has been fetched success"));
    }

    public function update($id,$request){
        $Store = Store::find($id);
        if (!$Store){
            return Response::errorResponse(__("admin/store.not found store"));
        }

        $Store->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        if ($request->media){
            $media = $Store->media;
            if ($media){
                $this->removeFile($media->file_path);
                $media->delete();
            }

            $path = "Store/";
            $file_name = $this->SaveFile($request->media,$path);
            $type = $this->getFileType($request->media);
            Media::create([
                'mediable_type' => $Store->getMorphClass(),
                'mediable_id' => $Store->id,
                'title' => "Store Logo",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse($Store,__("admin/store.Store has been updated success"));
    }

    public function changePassword($id,$request){
        $Store = Store::find($id);
        if (!$Store){
            return Response::errorResponse(__("admin/store.not found store"));
        }

        $Store->update([
            "password" => Hash::make($request->password)
        ]);
        return Response::successResponse([],__("admin/store.password has been changed success"));
    }

    public function ChangeStatus($id){
        $Store = Store::find($id);
        if (!$Store){
            return Response::errorResponse(__("admin/store.not found store"));
        }

        if($Store->is_active == 1){
            $Store->update([
                "is_active" => 0
            ]);
        }else{
            $Store->update([
                "is_active" => 1
            ]);
        }

        return Response::successResponse([],__("admin/store.status has been changed success"));
    }

    public function destroy($id){
        $Store = Store::find($id);
        if (!$Store){
            return Response::errorResponse(__("admin/store.not found store"));
        }

        $media = $Store->media;
        if ($media){
            $this->removeFile($media->file_path);
            $media->delete();
        }

        $Store->delete();

        return Response::successResponse([],__("admin/store.store has been deleted success"));
    }
}
