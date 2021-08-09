<?php

namespace App\Http\Controllers;

use App\Models\Product; 

class ProductController extends Controller
{
    /**
     * Display a listning of the products
     * 
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::orderBy('cost','desc')->paginate(10);
   
        return view('list',$data);
    }
}
