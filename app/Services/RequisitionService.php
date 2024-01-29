<?php

namespace App\Services;

use App\Repositories\RequisitionRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class RequisitionService
{
    private $requisitionRepository;

    public function __construct(RequisitionRepository $requisitionRepository)
    {
        $this->requisitionRepository = $requisitionRepository;
    }

    public function requestRequisition($request)
    {
        $user = $this->getLoggedUserInfo();
        $assetName = $request['name'];
        $specification = $request['specification'];
        $assetType = $request['asset_type'];
        $remarks = $request['remarks'];
        $requestRequisition = $this->requisitionRepository->setUserId(Auth::user()['id'])
                                    ->setAssetName($assetName)
                                    ->setSpecification($specification)
                                    ->setSssetType($assetType)
                                    ->setRemarks($remarks)
                                    ->setStatus(Config::get('variable_constants.requisition_status.pending'))
                                    ->setCreatedAt(date('Y-m-d H:i:s'))
                                    ->saveRequestRequisition();
        $data = null;
        if($requestRequisition)
        {
            $data = [
                'user' => $user,
                'assetName' => $assetName,
                'specification' => $specification,
                'assetType' => $assetType,
                'remarks' => $remarks,
            ];
        }
        return $data;
    }
    public function getLoggedUserInfo()
    {
        return [
            'employee_id' => Auth::user()['employee_id'],
            'email' => Auth::user()['email'],
            'full_name' => Auth::user()['full_name'],
            'nick_name' => Auth::user()['nick_name'],
            'phone_number' => Auth::user()['phone_number'],
            'user_id' => Auth::user()['id'],
        ];
    }


}
