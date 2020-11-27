<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function show()
    {
        $houses = House::orderby('id','DESC')->paginate(6);
        return view('index',compact('houses'));
    }
}
