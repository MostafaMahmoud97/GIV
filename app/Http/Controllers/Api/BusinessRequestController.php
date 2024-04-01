<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BusinessRequest\StoreRequest;
use App\Service\Api\BusinessRequestService;
use Illuminate\Http\Request;

class BusinessRequestController extends Controller
{
    protected $service;
    public function __construct(BusinessRequestService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request){
        return $this->service->store($request);
    }
}
