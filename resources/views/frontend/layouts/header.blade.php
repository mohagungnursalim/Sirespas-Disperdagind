<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <a href="index.html"><img src="{{ asset('img/GadeMart.png') }}" alt="" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar">
            <ul>

                <li><a class="nav-link scrollto {{ Request::is('/') || Request::is('results*') ? 'active' : '' }}" href="/">Bahan Pokok</a></li>
                <li><a class="nav-link scrollto {{ Request::is('tabel-harga*') ? 'active' : '' }}" href="/tabel-harga">Tabel Harga</a></li>
                <li><a class="nav-link scrollto {{ Request::is('aduan-pasar*') ? 'active' : '' }}" href="/aduan-pasar">Aduan Pasar</a></li>
                <li class="dropdown"><a href="#"><span>Website</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="https://disperdagind.palukota.go.id/">Web Disperdagind</a></li>
                        <li><a href="https://palukota.go.id/">Website Kota Palu</a></li>
                        @if (Auth::check())
                        <li><a href="/dashboard">Dashboard</a></li>
                        @else
                        <li><a href="/login">Login</a></li>
                        @endif
                        
                    </ul>
                </li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
