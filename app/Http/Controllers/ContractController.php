<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        
        return response()->json([
            'status' => true,
            'message' => 'Contracts retrieved successfully',
            'data' => $contracts
        ]);
    }
}