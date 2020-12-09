<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function show()
    {
//        $houses = House::paginate(10);

        $houses = House::orderBy('id','DESC')->paginate(10);
        return view('index',compact('houses'));
    }
}
