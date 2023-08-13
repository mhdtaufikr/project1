@extends('layout_customer.master')

@section('content')


 <!-- Header-->
 <header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <h1 class="display-5 fw-bold">Start Your Engine: Buy and Sell Motorbikes</h1>
                <p class="">Ready to kickstart your motorbike buying and selling endeavors? Look no further. Our platform provides the ignition for your deals, connecting you with a community that shares your passion</p>
                @if(auth()->guard('customer')->check())
                <!-- If user is logged in -->
                <h3 class="">Hello {{ auth()->guard('customer')->user()->name }} !</a>
            @else
                <!-- If user is not logged in -->
                <a class="btn btn-primary btn-lg" href="{{ url('customer/login') }}">Login</a>
            @endif
            
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
<section class="pt-4">
    <div class="container px-lg-5">
        <!-- Page Features-->
        <div class="row">
            @foreach ($getProduct as $data)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($data->product_picture)
                    <img src="{{ asset($data->product_picture) }}" class="card-img-top" alt="Product Picture">
                    @else
                    <div class="text-center py-3">
                        No Picture
                    </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $data->name }}</h5>
                        <p class="card-text">{!! $data->description !!}</p>
                        <p class="card-text">Price: Rp {{ number_format($data->price, 0, ',', '.') }}</p>
                        <div class="d-flex align-items-center justify-content-between"> <!-- Add d-flex align-items-center class here -->
                            @if ($data->status == 0)
                                <span class="badge bg-success">Available</span>
                            @elseif ($data->status == 1)
                                <span class="badge bg-danger">Sold</span>
                            @endif
                            <div>
                                <a href="{{ url('customer/detail/'.encrypt($data->id) ) }}" class="btn btn-primary btn-sm" role="button">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


@endsection