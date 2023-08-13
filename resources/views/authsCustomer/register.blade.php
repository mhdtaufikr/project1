<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header text-center justify-content-center"><h1>LOGIN</h1></div>
                                    <div class="card-body">
                                        <!--alert success -->
                                        @if (session('statusLogin'))
                                        <div class="alert alert-warning" role="alert">
                                            <strong>{{ session('statusLogin') }}</strong>
                                        </div> 
                                        @elseif(session('statusLogout'))
                                        <div class="alert alert-success" role="alert">
                                            <strong>{{ session('statusLogout') }}</strong>
                                        </div> 
                                        @endif

                                        <!--alert success -->

                                    <!-- Registration form -->
                                    <form action="{{ url('customer/register/store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Form Group (name) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="name">Name</label>
                                            <input class="form-control" id="name" type="text" placeholder="Enter your name" name="name" required>
                                        </div>
                                        <!-- Form Group (email address) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input class="form-control" id="email" type="email" placeholder="Enter email address" name="email" required>
                                        </div>
                                        <!-- Form Group (password) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control" id="password" type="password" placeholder="Enter password" name="password" required>
                                        </div>
                                        <!-- Form Group (confirm password) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                                            <input class="form-control" id="password_confirmation" type="password" placeholder="Confirm password" name="password_confirmation" required>
                                        </div>
                                        <!-- Form Group (address) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="address">Address</label>
                                            <textarea class="form-control" id="address" type="text" placeholder="Enter your address" name="address" required></textarea>
                                        </div>
                                        <!-- Form Group (profile picture) -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="profile_picture">Profile Picture</label>
                                            <input class="form-control" id="profile_picture" type="file" name="profile_picture" accept="image/*">
                                        </div>
                                        <!-- Form Group (register box) -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>
                                    </form>


                                        
                                    </div>
                                    <div class="card-footer text-center justify-content-center">
                                        <div class="col-12 small">Copyright &copy; 2023</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('assets/js/scripts.js')}}"></script>
    </body>
</html>
