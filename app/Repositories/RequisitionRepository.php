<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RequisitionRepository
{
    private $userId, $assetName, $specification, $assetType, $remarks, $status, $createdAt;
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function setAssetName($assetName)
    {
        $this->assetName = $assetName;
        return $this;
    }
    public function setSpecification($specification)
    {
        $this->specification = $specification;
        return $this;
    }
    public function setSssetType($assetType)
    {
        $this->assetType = $assetType;
        return $this;
    }
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function saveRequestRequisition()
    {
        return DB::table('requisition_requests')
            ->insert([
                'user_id' => $this->userId,
                'asset_type_id' => $this->assetType,
                'name'=> $this->assetName,
                'specification'=> $this->specification,
                'remarks' => $this->remarks,
                'status' => $this->status,
                'created_at' => $this->createdAt
            ]);
    }

}
