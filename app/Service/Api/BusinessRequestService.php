<?php


namespace App\Service\Api;


use App\Models\BusinessRequest;
use App\Models\Media;
use App\Traits\GeneralFileService;
use Illuminate\Support\Facades\Response;

class BusinessRequestService
{
    use GeneralFileService;

    public function store($request){
        $BusinessRequest = BusinessRequest::create($request->all());

        if($request->national_id && count($request->national_id) > 0){
            $path = "National_Ids/";
            foreach ($request->national_id as $media){
                $file_name = $this->SaveFile($media,$path);
                $type = $this->getFileType($media);
                Media::create([
                    'mediable_type' => $BusinessRequest->getMorphClass(),
                    'mediable_id' => $BusinessRequest->id,
                    'title' => "National ID",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);
            }
        }

        if($request->commercial_record){
            $path = "commercial_record/";
            $file_name = $this->SaveFile($request->commercial_record,$path);
            $type = $this->getFileType($request->commercial_record);
            Media::create([
                'mediable_type' => $BusinessRequest->getMorphClass(),
                'mediable_id' => $BusinessRequest->id,
                'title' => "commercial record",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        if($request->tax_register){
            $path = "tax_register/";
            $file_name = $this->SaveFile($request->tax_register,$path);
            $type = $this->getFileType($request->tax_register);
            Media::create([
                'mediable_type' => $BusinessRequest->getMorphClass(),
                'mediable_id' => $BusinessRequest->id,
                'title' => "tax register",
                'type' => $type,
                'directory' => $path,
                'filename' => $file_name
            ]);
        }

        return Response::successResponse([],__("api/business_request.form has been sent success"));
    }
}
