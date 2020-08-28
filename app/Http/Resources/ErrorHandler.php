<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorHandler extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'message' => $this->message,
        ];
    }

    public function with($request) {
       return [
            'version' => '1.0.0',
            'status' => $this->status,
            'code' => $this->code,
            'valid_as_of' => date('D, d M Y H:i:s')
       ];
    }
}
