<?php

namespace App\Http\Controllers;

use App\Models\Product;  

abstract class Controller
{
    //


    function __construct()
    {
        // This constructor can be used to apply middleware or perform other setup tasks
    }

    function getProducts()
    {
        $prod = Product::all();
        return response()->json($prod);
    }
}
