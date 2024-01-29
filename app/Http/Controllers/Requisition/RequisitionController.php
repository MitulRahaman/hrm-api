<?php

namespace App\Http\Controllers\Requisition;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\RequisitionService;
use App\Http\Requests\RequisitionAddRequest;

class RequisitionController extends Controller
{
    private $requisitionService;

    public function __construct(RequisitionService $requisitionService)
    {
        $this->requisitionService = $requisitionService;
    }
    public function requestRequisition(RequisitionAddRequest $request)
    {
        $data = $this->requisitionService->requestRequisition($request->validated());
        if ($data) {
            return response()->json([
                'status' => 'true',
                'error' => 'null',
                'data' => $data,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'false',
                'error' => 'no data',
                'data' => $data,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
