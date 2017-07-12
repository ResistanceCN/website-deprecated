<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function agent($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function get(Request $request)
    {
        return $request->user();
    }
}
