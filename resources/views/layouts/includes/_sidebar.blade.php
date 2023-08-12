<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Link (Charts)-->
                <a class="nav-link" href="{{url('/home')}}">
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Home
                </a>
                <a class="nav-link" href="{{url('/product')}}">
                    <div class="nav-link-icon"><i class="fas fa-file-signature"></i></div>
                    Product
                </a>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                {{-- <div class="sidenav-footer-title">{{ auth()->user()->name }}</div> --}}
            </div>
        </div>
    </nav>
</div>