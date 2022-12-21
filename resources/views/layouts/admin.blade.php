<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName ?? 'Admin - Profil' }}</title>
    @vite(['resources/sass/app.scss'])
</head>
<body>
<div class="container-fluid m-0 p-0 d-flex flex-nowrap">
    @section('navAdmin')
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;min-height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    Home
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                    Orders
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                    Products
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                    Customers
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
    @show
    <div class="main-container">
        @section('showProfil')
        <div class="m-4 d-flex p-2 flex-wrap justify-content-end align-items-center rounded shadow profil">
            <span class="fs-3">
                Patryk Dachwitz
            </span>
            <picture>
                <img class="rounded-circle border border-2" src="https://lh3.googleusercontent.com/ogw/AOh-ky1X_zBD7LjuFzqrnKQWjcA2DIpT8dN-SARD8mJZ8Q=s32-c-mo" width="45" height="45">
            </picture>
        </div>
        @show
        @section('content')
                <div class="content mx-4 mb-4 content-admin rounded">
                    <div class="filters deactive">
                        @yield('filter', "")
                    </div>
                    <div class="content">
                        <div class="header">
                            @yield('header', "")
                        </div>
                        @yield('itemGroup', "")
                    </div>
                </div>
        @show
    </div>
</div>
@vite(['resources/js/admin.js'])
</body>
</html>