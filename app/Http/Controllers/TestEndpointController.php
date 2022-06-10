<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestEndpointController extends Controller
{
    public function getUser()
    {
        return json_encode(Auth::user());
        // return "hello, world";
    }
}
