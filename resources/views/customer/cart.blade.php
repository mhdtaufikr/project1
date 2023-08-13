@extends('layout_customer.master')

@section('content')
<div class="container px-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Cart</div>
                <div class="card-body">
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
                    <div class="mb-4 text-center">
                        <h1>RideDealExchange</h1>
                    </div>

                    <div class="mb-4 text-center">
                        <p>Thank you for shopping with us and placing your trust in our website. We appreciate your business and value you as our customer. Below, you can find the details of the items in your cart:</p>
                    </div>

                    @if ($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                    @else
                    <button id="exportButton" class="btn-sm btn btn-primary">Export to Excel</button>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    @if ($item->product_picture)
                                        <img src="{{ asset($item->product_picture) }}" alt="Product Picture" class="img-thumbnail" style="max-width: 100px;">
                                    @else
                                        No Picture
                                    @endif
                                </td>
                                <td>{!! $item->description !!}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($item->status == 1)
                                        <span class="badge bg-success">Sold</span>
                                    @endif
                                </td>
                                <td>
                                    
                                    @if ($item->status != 1)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payModal{{$item->id}}">Pay</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{$item->id}}">Cancel Order</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    

                        <!-- Pagination Links -->
                        {{ $cartItems->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Pay Modals -->
    @foreach ($cartItems as $item)
        <div class="modal fade" id="payModal{{$item->id}}" tabindex="-1" aria-labelledby="payModalLabel{{$item->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payModalLabel{{$item->id}}">Pay for {{$item->name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/customer/pay')}}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{$item->id}}">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Enter the amount to pay (Rp)</label>
                                <input type="text" class="form-control" id="price" name="amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelModal{{$item->id}}" tabindex="-1" aria-labelledby="cancelModalLabel{{$item->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel{{$item->id}}">Cancel Order for {{$item->name}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Order</button>
                    <form action="{{ url('/customer/cancel-order') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <button type="submit" class="btn btn-danger">Yes, Cancel Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var priceInput = document.getElementById("price");
            
            priceInput.addEventListener("input", function() {
                var inputValue = this.value;
                if (inputValue !== "") {
                    var numericValue = parseFloat(inputValue.replace(/[^0-9.-]/g, ""));
                    var formattedValue = numericValue.toLocaleString('en-US');
                    this.value = formattedValue;
                }
            });
        });
    </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

   <script>
       document.getElementById("exportButton").addEventListener("click", function() {
           // Create a data array containing the cart items
           var data = [
               ["Product", "Description", "Price"],
               @foreach ($cartItems as $item)
                   ["{{ $item->name }}", "{{ strip_tags($item->description) }}", "{{ number_format($item->price, 0, '.', '') }}"],
               @endforeach
           ];
   
           // Create a new workbook and worksheet
           var wb = XLSX.utils.book_new();
           var ws = XLSX.utils.aoa_to_sheet(data);
   
           // Add the worksheet to the workbook
           XLSX.utils.book_append_sheet(wb, ws, "Cart");
   
           // Generate a blob from the workbook
           var blob = new Blob([s2ab(XLSX.write(wb, { bookType: "xlsx", type: "binary" }))], {
               type: "application/octet-stream"
           });
   
           // Create a download link and trigger a click event to start the download
           var link = document.createElement("a");
           link.href = URL.createObjectURL(blob);
           link.download = "cart.xlsx";
           link.click();
       });
   
       // Convert a string to an ArrayBuffer
       function s2ab(s) {
           var buf = new ArrayBuffer(s.length);
           var view = new Uint8Array(buf);
           for (var i = 0; i < s.length; i++) {
               view[i] = s.charCodeAt(i) & 0xff;
           }
           return buf;
       }
   </script>
   
    
@endsection
