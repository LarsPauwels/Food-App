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
        $data = [
            'id' => $this->id,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'deleted_at' => $this->when(Auth::user()->isAdmin(), $this->deleted_at),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => new RoleResource(UserModel::withTrashed()->find($this->id)->role)
        ];

        $roleName = strtolower($this->role->name);
        if (!empty($this->$roleName)) {
            if (isset($this->$roleName[0])) {
                $roleId = $this->$roleName[0]->id;
                $data += [
                    $roleName => $this->$roleName[0]->detail,
                    $roleName.'_id' => $roleId
                ];
            } else if(isset($this->$roleName->id)) {
                $roleId = $this->$roleName->id;
                $data += [
                    $roleName => $this->$roleName->detail,
                    $roleName.'_id' => $roleId
                ];
            }

            if ($roleName === 'employee') {
                $data += [
                    'company_id' => $this->employee->company_id
                ];
            }
        }

        return $data;
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
