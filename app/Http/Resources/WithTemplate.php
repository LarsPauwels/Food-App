<?php

namespace App\Http\Resources;

class WithTemplate {
    public static function with() {
        return [
            'version' => '1.0.0',
            'status' => 'success',
            'code' => 200,
            'valid_as_of' => date('D, d M Y H:i:s')
        ];
    }
}