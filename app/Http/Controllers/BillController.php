<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmRequest;
use App\Models\Bill;
use App\Models\House;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BillController extends Controller
{
    public function confirmIndex()
    {
        $subDay = Carbon::parse(Session::get('userRent')['checkIn'])->diffInDays(Session::get('userRent')['checkOut']);
        $bookDay = $subDay + 1;
        $house = House::findOrFail(Session::get('userRent')['house_id']);
        $totalPrice = $bookDay*$house->price;
        return view('frontend.house.confirm',compact('bookDay','house','totalPrice'));

    }

    public function confirmPost(ConfirmRequest $request)
    {
        $bill = new Bill();
        $bill->totalPrice = $request->totalPrice;
        $bill->checkIn = $request->checkIn;
        $bill->checkOut = $request->checkOut;
        $bill->house_id = $request->house_id;
        $bill->user_id = $request->user_id;
//        dd($bill->checkIn);
        $dateNow = \Illuminate\Support\Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        if ($bill->checkIn <= $bill->checkOut && $dateNow <= $bill->checkIn) {
            $bill->save();
            return redirect()->route('bill.success');
        } else {
            return redirect()->back()->with('thongbao','Không được đặt nhà ngày quá khứ, ngày trả phòng phải sau ngày đặt phòng');
        }
//        $bill->save();
//        return redirect()->route('bill.success');
    }

    public function success()
    {
        return view('frontend.house.confirm-success');
    }
}
