<?php


namespace App\Service\Admin;


use App\Models\Attribute;
use App\Models\Value;
use Illuminate\Support\Facades\Response;

class AttributeService
{
    public function indexAttributes(){
        $Attributes = Attribute::with("Values")->paginate(20);
        return Response::successResponse($Attributes,__("admin/attributes.attributes have been fetched success"));
    }

    public function storeAttribute($request){
        $Attribute = Attribute::create([
            "title" => $request->title
        ]);

        $Values = explode(",",$request->values);
        foreach ($Values as $value){
            Value::create([
                "attribute_id" => $Attribute->id,
                "title" => trim($value)
            ]);
        }

        return Response::successResponse($Attribute,__("admin/attributes.attribute has been created success"));
    }

    public function showAttribute($id){
        $Attribute = Attribute::with("Values")->find($id);
        if (!$Attribute){
            return Response::errorResponse(__("admin/attributes.not found attribute"));
        }

        return Response::successResponse($Attribute,__("admin/attributes.attribute has been fetched success"));
    }

    public function updateAttribute($id,$request){
        $Attribute = Attribute::find($id);
        if (!$Attribute){
            return Response::errorResponse(__("admin/attributes.not found attribute"));
        }

        $Attribute->update($request->all());
        return Response::successResponse([],__("admin/attributes.attribute has been updated success"));
    }

    public function destroyAttribute($id){
        $Attribute = Attribute::with("Values")->find($id);
        if (!$Attribute){
            return Response::errorResponse(__("admin/attributes.not found attribute"));
        }

        $Values = $Attribute->Values();
        $Values->delete();
        $Attribute->delete();

        return Response::successResponse([],__("admin/attributes.attribute has been deleted success"));
    }

    public function storeValue($request){
        $Value = Value::create($request->all());
        return Response::successResponse($Value,__("admin/attributes.value has been created success"));
    }

    public function updateValue($id,$request){
        $Value = Value::find($id);
        if (!$Value){
            return Response::errorResponse(__("admin/attributes.not found value"));
        }

        $Value->update($request->all());
        return Response::successResponse([],__("admin/attributes.value has been updated success"));
    }

    public function destroyValue($id){
        $Value = Value::find($id);
        if (!$Value){
            return Response::errorResponse(__("admin/attributes.not found value"));
        }

        $Value->delete();
        return Response::successResponse([],__("admin/attributes.value has been deleted success"));
    }
}
