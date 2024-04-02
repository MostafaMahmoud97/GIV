<?php


namespace App\Service\Admin;


use App\Http\Resources\Admin\BusinessRequest\IndexPaginateResource;
use App\Models\BusinessRequest;
use Illuminate\Support\Facades\Response;

class BusinessRequestService
{
    public function CountNewRequest(){
        $BusinessRequestsCount = BusinessRequest::where("is_view",0)->get()->count();
        return Response::successResponse(["number" => $BusinessRequestsCount],__("admin/business_request.count has been fetched success"));
    }

    public function index($request){
        $BusinessRequests = BusinessRequest::with(["national_ids_media","commercial_record_media","tax_register_media"])
            ->where("store_name","like","%".$request->search."%")
            ->OrWhere("phone_number","like","%".$request->search."%")
            ->OrWhere("email","like","%".$request->search."%")
            ->paginate(10);

        return Response::successResponse(IndexPaginateResource::make($BusinessRequests),__("admin/business_request.requests have been fetched success"));
    }

    public function Show($id){
        $BusinessRequests = BusinessRequest::with(["national_ids_media","commercial_record_media","tax_register_media"])->find($id);

        if (!$BusinessRequests){
            return Response::errorResponse(__("admin/business_request.not found business request"));
        }

        $BusinessRequests->is_view = 1;
        $BusinessRequests->save();

        return Response::successResponse($BusinessRequests,__("admin/business_request.request has been fetched success"));
    }

    public function delete($id){
        $BusinessRequests = BusinessRequest::find($id);

        if (!$BusinessRequests){
            return Response::errorResponse(__("admin/business_request.not found business request"));
        }

        $media = $BusinessRequests->media;
        foreach ($media as $item){
            $item->delete();
        }

        $BusinessRequests->delete();

        return Response::successResponse([],__("admin/business_request.request has been deleted success"));
    }
}
