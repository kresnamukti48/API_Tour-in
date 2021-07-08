<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
{
    public function profile()
    {
        return responder()->success(Auth::user());
    }
}
