@extends('frontend.master.master')
@section('content')

    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">Xem chi tiết</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="listings-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Single Listings Slides -->

                </div>
            </div>

            <div class="row justify-content-center box-house-detail">
                <div class="col-12 col-lg-9 mt-3">
                    <div class="listings-content">

                        <div class="row">

                            <div class="col-md-6">
{{--                                <div class="single-listings-sliders owl-carousel" >--}}
                                <div>
                                     <!-- Single Slide -->
{{--                                    <img src="{{ asset('/storage/'.$house->image) }}" alt="">--}}
                                    <!-- Single Slide -->
{{--                                    <img src="{{ asset('/storage/'.$house->image) }}" alt="">--}}

                                    @foreach($house->images as $image)
                                        <img src="{{asset('/storage/'.$image->image)}}" alt="">
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Price -->
                                <div class="list-price">
                                    <p>Giá: {{ number_format($house->price,0,",",".") }} VNĐ/Ngày</p>
                                </div>
                                <h5>{{ $house->name }}</h5>
                                <p class="location"><img src="img/icons/location.png" alt="">{{ $house->address }}</p>
                                <p>{{ $house->description }}</p>
                                <!-- Meta -->
                                <div class="property-meta-data d-flex align-items-end">
                                    <div class="new-tag">
                                        <img src="img/icons/new.png" alt="">
                                    </div>
                                    <div class="bathroom">
                                        <img src="img/icons/bathtub.png" alt="">
                                        <span>{{ $house->bathroom }}</span>
                                    </div>
                                    <div class="garage">
                                        <img src="img/icons/garage.png" alt="">
                                        <span>{{ $house->bedroom }}</span>
                                    </div>
                                    <div class="space">
                                        <img src="img/icons/space.png" alt="">
                                        <span>120 sq ft</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="rent-house mt-5">
                        <form action="" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <input hidden type="text" name="house_id" value="{{ $house->id }}">
                                    <input hidden type="text" name="user_id" value="@if (\Illuminate\Support\Facades\Auth::check())
                                    {{ \Illuminate\Support\Facades\Auth::user()->id }}
                                    @endif">

                                    <div class="form-group">
                                        <label for="">Ngày đặt phòng</label>
                                        <input type="text" readonly id="timeCheckIn" class="form-control" name="checkIn" value="{{old('checkIn')}}"/>
{{--                                        <input class="form-control" type="date" name="checkIn">--}}
                                    </div>
                                    @if ($errors->has('checkIn'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('checkIn') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Ngày trả phòng</label>
                                        <input readonly id="timeCheckOut" class="form-control" name="checkOut" value="{{old('checkOut')}}"/>
{{--                                        <input class="form-control" type="date" name="checkOut">--}}
                                    </div>
                                    @if ($errors->has('checkOut'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('checkOut') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <button class="btn btn-success" type="submit"
                                    @if (\Illuminate\Support\Facades\Auth::check())
                                        @else
                                    href="{{ route('login.login') }}"
                                        @endif
                            >
                                Đặt phòng</button>
                        </form>
                    </div>

                </div>
                <div class="col-12 col-lg-3 mt-3">

                    <div class="realtor-info">
                        <img src="storage/images/{{ $house->user->image }}" alt="">
                        <div class="realtor---info">
                            <h5 class="mt-3">{{ $house->user->name }}</h5>
                            <p>Chủ nhà</p>
                            <h6><img src="storage/images/{{ $house->user->image }}" alt="">{{ $house->user->phone }}</h6>
                            <h6><img src="storage/images/{{ $house->user->image }}" alt="">{{ $house->user->email }}</h6>
                        </div>

                    </div>

                </div>
            </div>

        {{-- <div class="row">
            <div class="col-12">
                <div class="listings-maps mt-100">
                    <div id="googleMap"></div>
                </div>
            </div>
        </div> --}}

        <!-- Listing Maps -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="listings-maps mt-100">
                        <div id="googleMap"></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
