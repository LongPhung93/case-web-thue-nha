@extends('frontend.master.master')
@section('content')
    @include('frontend.master.slider')
    <div class="south-search-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="advanced-search-form">
                        <!-- Search Title -->
{{--                        <div class="search-title">--}}
{{--                            <p>Search for your home</p>--}}
{{--                        </div>--}}
                        <!-- Search Form -->
                        <form action="{{route('house.search')}}" method="POST" id="advanceSearch">
                            @csrf
                            <div class="row">

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Tên" value="{{ request('name') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ request('address') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <input type="number" min="100000"  class="form-control" name="minPrice" placeholder="Gía thấp nhất" value="{{ request('minPrice') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <input type="number" min="500000"  class="form-control" name="maxPrice" placeholder="Giá cao nhất" value="{{ request('maxPrice') }}">
                                    </div>
                                </div>


                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control " name="typeHouse">
                                            <option value="{{ null }}">Loại căn hộ</option>
                                            <option value="Nhà nghỉ">Nhà nghỉ</option>
                                            <option value="Khách sạn">Khách sạn</option>
                                            <option value="Homestay">Homestay</option>
                                            <option value="Penhouse">Penhouse</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control " name="bedroom">
                                            <option value="{{ null }}">Số phòng ngủ</option>
                                            <option value="1">1 Phòng</option>
                                            <option value="2">2 Phòng</option>
                                            <option value="3">3 Phòng</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control " name="bathroom">
                                            <option value="{{ null }}">Số phòng tắm</option>
                                            <option value="1">1 Phòng</option>
                                            <option value="2">2 Phòng</option>
                                            <option value="3">3 Phòng</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 box-center">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn south-btn">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="featured-properties-area section-padding-100-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp">
                        <h2>Danh sách nhà</h2>
                    </div>
                </div>
            </div>

            <div class="row">
            {{-- {{ dd($houses[3]->images()->first()) }} --}}

            @forelse ($houses as $house)
                <!-- Single Featured Property -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
                            <!-- Property Thumbnail -->

{{--            @dd($house)--}}
                            <div class="property-thumb">
                                <a href="{{ route('house.detail', $house->id) }}">
                                    @if(!empty($house->images()->first()))
                                    <img
                                        src="{{asset('storage/'.$house->images()->first()->image)}}"
                                        class="img-fluid" style="width:1024px;height:200px;"
                                    >
                                    @endif
                                </a>


                                <div class="tag">
                                    <span>For Sale</span>
                                </div>
                                <div class="list-price">
                                    <p>{{ number_format($house->price,0,",",".") }} VNĐ/Ngày</p>
                                </div>
                            </div>
                            <!-- Property Content -->
                            <div class="property-content">
{{--                                <a href="{{ route('house.detail', $house->id) }}">--}}
                                    <h5>{{ $house->name }}</h5>
                                </a>

                                <p class="location"><img src="img/icons/location.png" alt="">{{ $house->address }}</p>
                                <p>{{ \Illuminate\Support\Str::words($house->description, 15, ' [...]') }}</p>
                                <div class="property-meta-data d-flex align-items-end justify-content-between">
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
                @empty
                    <div class="col-md-12">
                        <p class="text-center">Không tìm thấy kết quả nào phù hợp với yêu cầu của bạn!</p>
                    </div>
                @endforelse
{{--                {{ $houses->appends(request()->query()) }}--}}
            </div>
            <div class="row">
                <div class="col-md-12 box-paginate">
{{--                     {{ $houses->links() }}--}}
{{--                    {{ $houses->appends(request()->query()) }}--}}
                </div>
            </div>
        </div>
    </section>

    <!-- ##### Call To Action Area Start ##### -->
    <section class="call-to-action-area bg-fixed bg-overlay-black" style="background-image: url(img/bg-img/cta.jpg)">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay="300ms">Bạn muốn tìm kiếm một ngôi nhà mơ ước Hãy đến với chúng tôi !</h2>
{{--                        <h6 class="wow fadeInUp" data-wow-delay="400ms">Suspendisse dictum enim sit amet libero malesuada feugiat.</h6>--}}
{{--                        <a href="" class="btn south-btn mt-50 wow fadeInUp" data-wow-delay="500ms">Search</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Call To Action Area End ##### -->


    <!-- ##### Testimonials Area Start ##### -->
    <section class="south-testimonials-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp" data-wow-delay="250ms">
                        <h2>Cảm nhận khách hàng</h2>
{{--                        <p>Suspendisse dictum enim sit amet libero malesuada feugiat.</p>--}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="testimonials-slides owl-carousel wow fadeInUp" data-wow-delay="500ms">

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide text-center">
                            <h5>Ngôi nhà tuyệt vời cho tôi</h5>
                            <p>Giá cả hợp lý, tiện nghi, giao thông rất thuận tiện. Vote 5 sao</p>

                            <div class="testimonial-author-info">
                                <img src="img/bg-img/ngoctrinh.jpeg" alt="">
                                <p>Ngọc Trinh, <span>Khách hàng</span></p>
                            </div>
                        </div>

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide text-center">
                            <h5>Tiện nghi, hiện đại</h5>
                            <p>Rất đáng đồng tiền bát gạo. Trên cả tuyệt vời, ngôi nhà rất nhiều tiện nghi, giá cả hợp lý, kèm với đó là những dịch vụ đẳng cấp phù hợp với người bận rộn như tôi</p>

                            <div class="testimonial-author-info">
                                <img src="img/bg-img/chipu.jpg" alt="">
                                <p>Chi Pu, <span>Khách hàng</span></p>
                            </div>
                        </div>

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide text-center">
                            <h5>Amazing, gút chóp</h5>
                            <p>Mới đầu tôi cứ nghĩ ngôi nhà work không tốt lắm, tuy vậy thực tế lại work rất tốt với nhau. Không biết nói gì hơn, chúc mừng các bạn đã làm rất tốt!</p>

                            <div class="testimonial-author-info">
                                <img src="img/bg-img/binz.jpeg" alt="">
                                <p>BinZ, <span>Khách hàng</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Testimonials Area End ##### -->
@endsection
