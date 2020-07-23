<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\WithTemplate;
use App\User;

class Auth extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'user' => new UserResource(User::find($this->id)),
            'token' => $this->token
        ];
    }


    public function with($request) {
        return WithTemplate::with();
    }
}
