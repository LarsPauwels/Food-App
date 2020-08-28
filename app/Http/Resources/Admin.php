<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Admin extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'user_id' => $this->user_id,
                'email' => $this->user->email,
                'deleted_at' => $this->user->deleted_at
            ]
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
