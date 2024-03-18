<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index() {
        $addresses = Address::all();

        return response()->json([
            'success' => true,
            'results' => $addresses,
        ]);
    }
}
