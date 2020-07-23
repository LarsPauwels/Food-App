<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\WithTemplate;
use App\User as UserModel;

class User extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'deleted_at' => $this->when(Auth::user()->isAdmin(), $this->deleted_at),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => new RoleResource(UserModel::withTrashed()->find($this->id)->role)
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
