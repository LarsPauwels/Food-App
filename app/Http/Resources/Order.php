<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Base as BaseResource;

use App\Http\Helpers\ResourceHelper;

class Order extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'employee' => $this->employee ? $this->employee->firstname.' '.$this->employee->lastname : null,
            'products' => BaseResource::collection($this->bases)
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
