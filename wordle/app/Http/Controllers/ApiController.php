<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function check(Request $request)
    {
        return 'check test';
    }
}
