<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController
{
    public function get(Request $request)
    {
        return $request->user();
    }
}
