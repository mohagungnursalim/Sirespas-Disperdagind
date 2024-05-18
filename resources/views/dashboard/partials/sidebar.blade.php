
<ul class="navbar-nav  sidebar sidebar-light accordion" id="accordionSidebar">


    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
           
           <img src="{{ asset('img/kotapalu.png') }}" width="60">
           
            
        </div>
        <div class="sidebar-brand-text mx-3">
            @foreach ($settings as $setting )
                {{ $setting->nama }}
            @endforeach
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ Request::is('dashboard/retribusi*') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard/retribusi">
            <i class="fas fa-fw fa-table"></i>
            <span>Retribusi</span></a>
    </li>
    
    @can('admin')
    <li class="nav-item {{ Request::is('dashboard/pasar*') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard/pasar">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Data Pasar</span></a>
    </li>
    @endcan
    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('dashboard/profile') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard/profile">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Edit Profil</span></a>
    </li>
    @can('admin')
    @if (auth()->user()->operator == 'hanyalihat')
        
    @else
    <li class="nav-item {{ Request::is('dashboard/buat-akun') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard/buat-akun">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Kelola Akun</span></a>
    </li>
    <li class="nav-item {{ Request::is('dashboard/setting-app*') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard/setting-app">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Setting App</span></a>
    </li> 
    @endif
    @endcan
    

    <hr class="sidebar-divider">
   

    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}

</ul>