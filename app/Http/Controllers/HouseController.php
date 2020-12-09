<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddHouseRequest;
use App\Http\Requests\BookDayRequest;
use App\Models\House;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HouseController extends Controller
{
    public function show()
    {
        return view('frontend.house.add-house');
    }

    public function store(AddHouseRequest $request)
    {
        $house = new House();
        $house->name = $request->name;
        $house->price = $request->price;
        $house->address = $request->address;
        $house->typeHouse = $request->typeHouse;
        $house->typeRoom = $request->typeRoom;
        $house->bedroom = $request->bedroom;
        $house->bathroom = $request->bathroom;
        $house->description = $request->description;
        $house->user_id = $request->user_id;

        if ($request->hasFile('photos')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('photos');
            $exe_flg = true;
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if (!$check) {
                    $exe_flg = false;
                    break;
                }
            }
            if ($exe_flg) {
                $house->save();

                foreach ($request->photos as $photo) {
//                  dd($photo);
                    $filename = $photo->store('images', 'public');
                    $image = new Image();
                    $image->image = $filename;
                    $image->house_id = $house->id;
                    $image->save();
                }
                return redirect()->route('index');
            } else {
                return redirect()->route('houses.list');
            }
        }

//        if ($request->hasFile('photos')) {
//            $house->save();
//            foreach ($request->photos as $photo) {
//                $filename = $photo->store('images', 'public');
//                $image = new Image();
//                $image->image = $filename;
//                $image->house_id = $house->id;
//                $image->save();
//            }
//            return redirect()->route('index');
//        }
    }

    public function detail($id)
    {
        $house = House::findOrFail($id);
        return view('frontend.house.detail-house',compact('house'));
    }

    public function rentHome(BookDayRequest $request)
    {
        $userRent = [];
        $userRent['id'] = $request->user_id;
        $userRent['house_id'] = $request->house_id;
        $userRent['checkIn'] = date('Y-m-d',strtotime($request->checkIn));
        $userRent['checkOut'] = date('Y-m-d',strtotime($request->checkOut));
        Session::put('userRent', $userRent);
        $dateNow = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        return redirect()->route('house.confirm',$request->house_id);
    }

    public function search(Request $request) {

        $name = $request->name;
        $address = $request->address;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $typeHouse = $request->typeHouse;
        $typeRoom = $request->typeRoom;
        $bathroom = $request->bathroom;
        $bedroom = $request->bedroom;
        $houses = House::query();

        if (!empty($name)) {
            $houses = $houses->where('name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $houses = $houses->whereBetween('price', [$minPrice, $maxPrice]);
        } else if(!empty($minPrice) && empty($maxPrice)) {
            $houses = $houses->where('price', '>=' , $minPrice);
        } else if(empty($minPrice) && !empty($maxPrice)) {
            $houses = $houses->where('price', '<=' , $maxPrice);
        }

        if (!empty($address)) {
            $houses = $houses->where('address', 'LIKE', '%' . $address . '%');
        }

        if (!empty($address)) {
            $houses = $houses->where('address','LIKE','%'.$address.'%');
        }

        if (!empty($typeHouse)) {
            $houses = $houses->where('typeHouse', 'LIKE', '%' . $typeHouse . '%');
        }

        if (!empty($bedroom)) {
            $houses = $houses->where('bedroom', 'LIKE', '%' . $bedroom . '%');
        }

        if (!empty($bathroom)) {
            $houses = $houses->where('bathroom', 'LIKE', '%' . $bathroom . '%');
        }

        $houses = $houses->get();

        return view('index', compact('houses'));
    }

    public function showHouseList($id) {

        $houses = DB::table('bills')
            ->join('users as user_rent', 'bills.user_id', 'user_rent.id')
            ->join('houses', 'bills.house_id', 'houses.id')
            ->join('users', 'houses.user_id', 'users.id')
            ->select('bills.*', 'houses.name as house_name', 'users.name', 'users.phone', 'user_rent.name as rent_name')
            ->where('user_rent.id', $id)
            ->get()
        ;

        $totalPriceByUser = DB::table('bills')
            ->join('users', 'bills.user_id', 'users.id')
            ->select('users.*',DB::raw('SUM(bills.totalPrice) as total'))
            ->groupBy('users.name')
            ->having('users.id', '=', $id)
            ->get()
        ;

        return view('frontend.house.house-order', compact('houses','totalPriceByUser'));
    }

    public function showCustomerHouse($id) {

        $user = User::findOrFail($id);
        $totalPriceByUser = DB::table('bills')
            ->join('houses', 'bills.house_id', 'houses.id')
            ->join('users', 'houses.user_id', 'users.id')
            ->select('bills.*', 'users.name', 'users.id', DB::raw('SUM(bills.totalPrice) as total'))
            ->groupBy('users.name')
            ->having('users.id','=', $id)
            ->get();

        $results = DB::table('bills')
            ->join('users as users1','bills.user_id', 'users1.id' )
            ->join('houses', 'bills.house_id', 'houses.id')
            ->join('users', 'houses.user_id', 'users.id')
            ->select('bills.*', DB::raw('users1.name as user_rent'), 'houses.name', DB::raw('users.name as user_name')  )
            ->where('houses.user_id', '=', $id)
            ->get();

        return view('frontend.house.house-customer', compact('user','totalPriceByUser','results'));
    }

}

