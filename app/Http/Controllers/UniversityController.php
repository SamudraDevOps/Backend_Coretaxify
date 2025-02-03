<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $univ = University::all();
        
        return response()->json([
            'status' => true,
            'message' => 'University retrieved successfully',
            'data' => $univ
        ]);
    }
}