<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidationHelper {
    /** 
     * checks if validation is valid for the attributes
     * 
     * @return boolean
     */ 
    public static function attributes(array $data) {
        if (array_key_exists('sort', $data)) {
            $data['sort'] = strtolower($data['sort']);
        }

        if (array_key_exists('delivered', $data)) {
            $data['delivered'] = strtolower($data['delivered']);
        }

        if (array_key_exists('date', $data)) {
            $data['date'] = strtolower($data['date']);
        }

        if (array_key_exists('active', $data)) {
            $data['active'] = filter_var($data['active'], FILTER_VALIDATE_BOOLEAN);
        }

        if (array_key_exists('employees', $data)) {
            $data['employees'] = filter_var($data['employees'], FILTER_VALIDATE_BOOLEAN);
        }

        if (array_key_exists('timesheet', $data)) {
            $data['timesheet'] = filter_var($data['timesheet'], FILTER_VALIDATE_BOOLEAN);
        }

        $validation = Validator::make($data, [
            'page' => ['integer'],
            'page_size' => ['integer', 'min:1', 'max:200'],
            'sort' => ['string', 'regex:(asc|desc)'],
            'search' => ['string', 'max:80'],
            'active' => ['boolean'],
            'employees' => ['boolean'],
            'timesheet' => ['boolean'],
            'delivered' => ['string', 'regex:(true|false|all)'],
            'date' => ['string', 'regex:(today|week|month|year)']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Auth functions
     * 
     * @return boolean
     */ 
    public static function auth(array $data) {
        $validation = Validator::make($data, [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }
	
	/** 
     * checks if validation is valid for the Auth Register function
     * 
     * @return boolean
     */ 
	public static function authRegister(array $data) {
		$messages = [
            'regex' => 'The password must contain at least one letter, uppercase letter and number.'
        ];

        $validation = Validator::make($data, [
            'email' => ['required', 'email', 'max:255', 'unique:App\User,email'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'role_id' => ['required', 'integer'],
            'remember' => ['required', 'boolean']
        ], $messages);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
	}

    /** 
     * checks if validation is valid for the Auth Register function
     * 
     * @return boolean
     */ 
    public static function user(array $data, $id = null) {
        $messages = [
            'regex' => 'The password must contain at least one letter, uppercase letter and number.'
        ];

        $validation = Validator::make($data, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'role_id' => ['integer']
        ], $messages);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the order functions
     * 
     * @return boolean
     */ 
    public static function order(array $data) {
        $validation = Validator::make($data, [
            'timesheet_id' => ['required', 'integer'],
            'bases.*.base_id' => ['required', 'integer', Rule::exists('bases', 'id')],
            'bases.*.toppings.*' => ['required', 'integer', Rule::exists('toppings', 'id')]
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Supplier functions
     * 
     * @return boolean
     */ 
    public static function supplier(array $data) {
        $validation = Validator::make($data, [
            'locked' => ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Detail functions
     * 
     * @return boolean
     */ 
    public static function detail(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Address functions
     * 
     * @return boolean
     */ 
    public static function address(array $data) {
        $validation = Validator::make($data, [
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Base functions
     * 
     * @return boolean
     */ 
    public static function base(array $data) {
        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:800'],
            'price' => ['required', 'max:255'],
            'isAvailable' => ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Topping functions
     * 
     * @return boolean
     */ 
    public static function topping(array $data) {
        $validation = Validator::make($data, [
            'toppings.*.name' => ['required', 'string', 'max:255'],
            'toppings.*.price' => ['required', 'max:255'],
            'toppings.*.isAvailable' => ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }

    /** 
     * checks if validation is valid for the Timesheet functions
     * 
     * @return boolean
     */ 
    public static function timesheet(array $data) {
        $validation = Validator::make($data, [
            'day' => ['required', 'string', 'max:255'],
            'from' => ['max:255'],
            'until' => ['max:255'],
            'active' =>  ['required', 'boolean']
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
    }
}