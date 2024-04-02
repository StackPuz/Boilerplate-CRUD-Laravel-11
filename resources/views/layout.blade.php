<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
    <link href="/css/style.css?1711963858662" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="/js/script.js?1711963858661"></script>
</head>
<body class="small">
    @auth
    <div class="wrapper">
        <input id="sidebar_toggle" type="checkbox" />
        <nav id="sidebar">
            <a href="/" class="bg-light border-bottom">
                <h4>StackPuz</h4>
            </a>
            <ul class="list-unstyled">
                <li>
                    <a href="/home" class="{{ Str::endsWith(request()->path(), 'home') ? 'active bg-primary' : '' }}">Home</a>
                </li>
                @foreach (auth()->user()->getMenu() as $menu)
                <li><a href="/{{$menu['path']}}" class="{{ explode('/', request()->path())[0] == $menu['path'] ? 'active bg-primary' : '' }}">{{$menu['title']}}</a></li>
                @endforeach
            </ul>
        </nav>
        <div id="body">
            <nav class="navbar bg-light border-bottom">
                <div class="container-fluid">
                    <label for="sidebar_toggle" class=" btn btn-primary btn-sm"><i class="fa fa-bars"></i></label>
                    <ul class="navbar-nav ms-auto">
                        <li id="searchbar_toggle_menu" class="d-none">
                            <a class="nav-link text-secondary" href="#"><label for="searchbar_toggle" class="d-lg-none"><i class="fa fa-search"></i></label></a>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link text-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#"><i class="fa fa-user"></i> <span class="d-none d-lg-inline"> {{ auth()->user()->name }}</span></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="/profile" class="dropdown-item"><i class="fa fa-user"></i> Profile</a>
                                <a href="/logout" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    @endauth
    @guest
    @yield('content')
    @endguest
</body>
</html>