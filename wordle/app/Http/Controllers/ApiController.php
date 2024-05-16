<?php

namespace App\Http\Controllers;

use App\Models\Validword;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function check(Request $request)
    {
        // Check if word is present in the call

        $word = $request->input('word');

        if (!$word) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Word is required'
            ], 422);
        }

        // Solution with MVC: we created a modal, migration and seeder for valid words
        $valid = Validword::where('word', $word)->first();
        if (!$valid) {
            return response()->json([
                'status' => 'error',
                'code' => 2,
                'message' => 'Supplied word is not valid'
            ], 422);
        }


        return 'check test';
    }
}
