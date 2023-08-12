@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                {{-- <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="tool"></i></div>
                            Rule App Menu
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div> --}}
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Product</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i>
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-add-label">Add Product</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <form action="{{ url('/product/store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label><b>Product Name</b></label>
                                            <input class="form-control" id="partner_name" name="partner_name" type="text" placeholder="Input Product Name" required/>
                                        </div>
                                     
                                        <div class="mb-3">
                                            <label><b>Description</b></label>
                                            <textarea class="form-control my-editor" id="my-editor" name="description" cols="30" rows="3" placeholder="" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label><b>Product Price</b></label>
                                            <input class="form-control" id="price" name="price" type="text" placeholder="Input Product Price" required/>
                                        </div>

                                        <div class="mb-3">
                                            <label><b>Product Picture</b></label>
                                            <input class="form-control" id="product_picture" name="product_picture" type="file" placeholder="Input Product Price" required/>
                                        </div>
                              </div>
                              <div class="modal-footer">
                                  <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                  <button class="btn btn-primary" type="submit">Save</button>
                              </div>
                              </form>
                              </div>
                            </div>
                          </div>


                    <div class="col-sm-12">
                      
                      <!--alert success -->
                      @if (session('status'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('status') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif

                    @if (session('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>{{ session('failed') }}</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif

                      <!--alert success -->
                      <!--validasi form-->
                        @if (count($errors)>0)
                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              <ul>
                                  <li><strong>Data Process Failed !</strong></li>
                                  @foreach ($errors->all() as $error)
                                      <li><strong>{{ $error }}</strong></li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                      <!--end validasi form-->
                    </div>
                </div>
                <div class="table-responsive">
                <table id="tablePartner" class="table table-bordered table-striped">
                  <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($getProduct as $data)
                    <tr class="text-center">
                        <td>{{ $no++ }}</td>
                        <td><strong class="mb-4">{{ $data->name }}</strong>
                        <br>
                          @if ($data->product_picture)
                            <img src="{{ asset($data->product_picture) }}" alt="Product Picture" style="max-width: 100px; max-height: 100px;">
                          @else
                              No Picture
                          @endif
                        </td>
                        <td>{!! $data->description !!}</td>

                        <td>Rp {{ number_format($data->price, 0, ',', '.') }}</td>
                        <td>
                              @if ($data->status == 0)
                                  <small class="badge bg-success">Available</small>
                              @elseif ($data->status == 1)
                                  <small class="badge bg-danger">Sold</small>
                              @endif
                        </td>
                        <td>
                            <button title="Edit Product" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                <i class="fas fa-edit"></i>
                              </button>

                            
                            <button title="Delete Product" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="modal-update{{ $data->id }}-label">Edit Partner</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/product/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                  <input name="id" type="number" value="{{$data->id}}" hidden>
                                <div class="mb-3">
                                  <label><b>Product Name</b></label>
                                  <input value="{{$data->name}}" class="form-control" id="partner_name" name="partner_name" type="text" placeholder="Input Product Name" required/>
                              </div>
                           
                              <div class="mb-3">
                                <label><b>Description</b></label>
                                <textarea class="form-control my-editor" id="my-editor" name="description" cols="30" rows="3" placeholder="" required>
                                    {{$data->description}}
                                </textarea>
                            </div>
                        
                              <div class="mb-3">
                                <label><b>Product Price</b></label>
                                <input value="{{$data->price}}" class="form-control" id="productPrice" name="price" type="text" placeholder="Input Product Price" required/>
                            </div>
                              
                              <div class="mb-3">
                                  <label><b>Product Picture</b></label>
                                  <input  class="form-control" id="product_picture" name="product_picture" type="file" placeholder="Input Product Price"/>
                              </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                        </form>
                      </div>
                          </div>
                        </div>
                      </div>
                    {{-- Modal Update --}}

                    {{-- Modal Delete --}}
                    <div class="modal fade" id="modal-delete{{ $data->id }}" tabindex="-1" aria-labelledby="modal-delete{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-delete{{ $data->id }}-label">Delete Product</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/product/delete') }}" method="POST">
                              @csrf
                              @method('delete')
                              <div class="modal-body">
                                  <input type="hidden" name="id" value="{{$data->id}}">
                                  <div class="form-group">
                                      Are you sure you want to delete <label for="partner">{{ $data->name }}</label>?
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-danger">Delete</button>
                              </div>
                          </form>
                          
                        </div>
                        </div>
                    </div>
                    {{-- Modal Delete --}}

                    {{--Modal Add Contract --}}
                    <div class="modal fade" id="modal-addContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-addContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-addContract{{ $data->id }}-label">Add Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/contract') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input hidden value="{{$data->id}}" class="form-control" id="id_partner" name="id_partner"/>
                                    </div>
                                  <div class="form-group">
                                    <label for="date-from">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label for="date-to">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                        </div>
                        </div>
                    </div>
                    {{--Modal Add Contract --}}


                     {{--Modal Edit Contract --}}
                     <div class="modal fade" id="modal-editContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-editContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-editContract{{ $data->id }}-label">Edit Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/contract/update') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id_partner" id="id_partner" value="{{$data->id_partner}}" hidden>
                                  <div class="form-group">
                                    <label for="date-from">From</label>
                                    <input value="{{\Carbon\Carbon::parse($data->start_date)->format('Y-m-d')}}" type="date" class="form-control" id="start_date" name="start_date" required>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label for="date-to">To</label>
                                    <input value="{{\Carbon\Carbon::parse($data->end_date)->format('Y-m-d')}}" type="date" class="form-control" id="end_date" name="end_date" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                        </div>
                        </div>
                    </div>
                    {{--Modal Add Contract --}}


                    {{-- Modal Show --}}
                    <div class="modal fade" id="modal-showContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-showContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-showContract{{ $data->id }}-label">Show Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/'.$data->id) }}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="date-from">From</label>
                                    <p  class="form-control">{{\Carbon\Carbon::parse($data->start_date)->format('Y-m-d')}}</p>
                                    <label for="date-from">To</label>
                                    <p  class="form-control">{{\Carbon\Carbon::parse($data->end_date)->format('Y-m-d')}}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    {{-- Modal Delete --}}



                    @endforeach
                  </tbody>
                </table>
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>


</main>
<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tablePartner").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var priceInput = document.getElementById("price");
    
        priceInput.addEventListener("input", function() {
            var inputValue = this.value;
            if (inputValue !== "") {
                var numericValue = parseFloat(inputValue.replace(/[^0-9.-]/g, ""));
                this.value = numericValue.toLocaleString('en-US');
            }
        });
    });
    </script>
<script>
  CKEDITOR.replaceAll('my-editor');
</script>
<script>
  $(document).ready(function () {
      // Function to format a number with commas
      function formatNumber(number) {
          return new Intl.NumberFormat().format(number);
      }

      // Function to remove commas and get numeric value
      function removeCommas(value) {
          return value.replace(/,/g, '');
      }

      // Get the input element
      var priceInput = $('#productPrice');

      // Update the input value when it changes
      priceInput.on('input', function () {
          var inputValue = removeCommas($(this).val()); // Remove existing commas
          if (!isNaN(inputValue)) {
              $(this).val(formatNumber(inputValue)); // Format and update the value
          }
      });

      // Before form submission, remove commas from the value
      $('form').on('submit', function () {
          var inputValue = removeCommas(priceInput.val());
          priceInput.val(inputValue); // Set the numeric value without commas
      });
  });
</script>

@endsection
