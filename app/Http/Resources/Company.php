<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\Employee as EmployeeResource;
use App\Address as AddressModel;

use App\Http\Helpers\ResourceHelper;

class Company extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        if (!empty($this->employees)) {
            foreach ($this->employees as $employee) {
                unset($employee->company_id);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->detail->name,
            'phone' => $this->detail->phone,
            'profit' => $this->profit ? $this->profit : ResourceHelper::companyProfit($this->id, 'today'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                UserResource::collection($this->user)
            ],
            'address' => new AddressResource(AddressModel::find($this->detail->address_id)),
            'employees' => EmployeeResource::collection($this->employees),
            'timesheets' => TimesheetResource::collection($this->timesheets)
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
