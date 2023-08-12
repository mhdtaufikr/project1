<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function index(){
   $getProduct = Product::get();
    return view('customer.index' ,compact('getProduct'));
   }
}
