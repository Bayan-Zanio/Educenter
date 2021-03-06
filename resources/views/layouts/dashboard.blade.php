<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @stack('css')
</head>

<body>

    <header class="py-2 bg-dark text-white mb-4">
        <div class="container">
         <div class="d-flex">
            <h1 class="h3">{{ config('app.name') }}</h1>

            
            @auth
            <div class="ms-auto">
            Hi, {{ Auth::user()->name }}
              <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
              <form id="logout" class="d-nome" action=" {{ route('logout') }} " method="post">
               @csrf
              </form>
            </div>
            @endauth
         </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <h4>Navigation Menu</h4>
                <ul class="nav nav-pills flex-column ">
                    <li class="nav-tiem"><a href="{{ route('admin.categories.create') }}" class="nav-link ">Dashboard</a></li>
                    <li class="nav-tiem"><a href="{{ route('admin.categories.index') }}" class="nav-link  @if(request()->routeIs('admin.categories.*')) active @endif">Categories</a></li>
                    <li class="nav-tiem"><a href="" class="nav-link">Products</a></li>
                </ul>
                
            </aside>
            <main class="col-md-9">
                <div class="mb-4">
                    <h3 class="text-primary">{{ $title ?? 'Default Title'}}</h3>
                    <h5 class="text-primary">{{ $subtitle ?? ''}}</h5>
                </div>
                
                {{ $slot }}
            </main>
        </div>
    </div>

    <script srv=" {{ asset('js/bootstrap.bundle.min.js') }} "></script>
    @stack('js')

</body>

</html>