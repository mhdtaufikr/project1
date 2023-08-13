@extends('layout_customer.master')

@section('content')
    <div class="container px-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $getProductDetail->name }}</div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Success Message -->
                            @if(Session::has('success'))
                            <div class="alert alert-success mt-4">
                                {{ Session::get('success') }}
                            </div>
                            @endif
                             <!-- Failed Message -->
                             @if(Session::has('failed'))
                             <div class="alert alert-danger mt-4">
                                 {{ Session::get('failed') }}
                             </div>
                            @endif
                            <div class="col-md-6">
                                @if ($getProductDetail->product_picture)
                                    <img src="{{ asset($getProductDetail->product_picture) }}" class="img-fluid mb-3" alt="Product Picture">
                                @else
                                    <div class="text-center py-3">
                                        No Picture
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p class="card-text">{!! $getProductDetail->description !!}</p>
                                <p class="card-text">Price: Rp {{ number_format($getProductDetail->price, 0, ',', '.') }}</p>
                                @if ($getProductDetail->status == 0)
                                    <span class="badge bg-success">Available</span>
                                @elseif ($getProductDetail->status == 1)
                                    <span class="badge bg-danger">Sold</span>
                                @endif

                                <!-- Add to Cart Button -->
                                <form action="{{ url('customer/cart/add', $getProductDetail->id) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addToCartModal">Add to Cart</button>
                                </form>

                                <!-- Check Your Order Button -->
                                <a href="{{ url('customer/cart/'.encrypt(auth()->guard('customer')->user()->id)) }}" class="btn btn-secondary mt-2">Check Your Order</a>
                            </div>
                        </div>

                        <!-- Buying Information -->
                        <div class="mt-4">
                            <h5>How to Buy</h5>
                            <p>Provide information on how customers can buy this product. Include details about the purchasing process, payment methods, and delivery options.</p>
                        </div>

                        <!-- Checkout and Payment -->
                        <div class="mt-4">
                            <h5>Checkout and Payment</h5>
                            <p>Review your cart items and proceed to checkout. Provide payment information and confirm your order.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to add this product to your cart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ url('customer/order') }}" method="POST">
                    @csrf
                    <input type="text" name="id" id="" value="{{$getProductDetail->id}}" hidden>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
