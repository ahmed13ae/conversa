<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExController extends Controller
{
   public function about(){
    $name='mohsen';
    return view('about',['name'=>$name]);
   }
}
