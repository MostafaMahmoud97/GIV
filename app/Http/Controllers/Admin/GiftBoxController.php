<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiftBox\StoreRequest;
use App\Http\Requests\Admin\GiftBox\UpdateRequest;
use App\Service\Admin\GiftBoxService;
use Illuminate\Http\Request;

class GiftBoxController extends Controller
{
    protected $service;

    public function __construct(GiftBoxService $service){
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function store(StoreRequest $request){
        return $this->service->store($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,UpdateRequest $request){
        return $this->service->update($id,$request);
    }

    public function ChangeStatus($id){
        return $this->service->ChangeStatus($id);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
}
