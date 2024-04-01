<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\BusinessRequestService;
use Illuminate\Http\Request;

class BusinessRequestController extends Controller
{
    protected $service;
    public function __construct(BusinessRequestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function show($id){
        return $this->service->Show($id);
    }

    public function delete($id){
        return $this->service->delete($id);
    }
}
