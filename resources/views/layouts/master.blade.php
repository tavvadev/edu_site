<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Education</title>



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL('/') }}/assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- Scripts -->
   @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

<!-- header code starts here  -->
<header class="edu-header">

<div class="top-login-sec">


</div>

        <div class="container container-xxl">
            <nav class="navbar navbar-expand-lg align-items-center navbar-light bg-link justify-content-start">

              <a class="navbar-brand d-flex align-items-center" href="javascript:void(0)">
                  <img src="/../assets/images/edutech_logo.png" alt="medichire-logo" width="180" height="32" class="img-fluid mb-0"/>
                  </a>
                  <img class="img-fluid d-block d-lg-none" src="/../assets/images/hemburger_menuicon.png" data-bs-toggle="offcanvas" data-bs-target="#demo" alt="offcanvas-menu" width="32" height="32"/>
             <!-- responsive menu for mobile here -->
                  <div class="offcanvas offcanvas-start align-items-start ps-0 ps-md-5" id="demo">
                    <div class="offcanvas-header">
                      <h1 class="offcanvas-title">
                        <a class="navbar-brand" href="javascript:void(0)">
                          <img src="../assets/images/medichire_logo.svg" alt="medichire-logo" width="180" height="32" class="img-fluid mb-0"/>
                          </a>
                      </h1>
                      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body justify-content-between w-100">
                      <ul class="navbar-nav ">
                        <li class="nav-item">
                          <a class="nav-link active" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('orders.index') }}">School Location</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">MIS Report</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Applications</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Documents</a>
                        </li> -->
                      </ul>

                      <ul class="navbar-nav ">

                      @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
        <!--
                            <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                            <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a></li>
                            <li><a class="nav-link" href="{{ route('products.index') }}">Manage Product</a></li> -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                      </ul>


                    </div>
                  </div>
<!-- responsive menu for mobile ends here  -->
              </nav>
            </div>

          </header>

          <section id="myCarousel" class="carousel slide" data-bs-ride="carousel">
          @if($_SERVER['REQUEST_URI'] == '/')
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
              <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item">
                <img src="assets/images/1x/banner.png" width="1200" height="400" class="img-fluid w-100" />

                <div class="container">
                  <div class="carousel-caption text-start">
                  <!--   <h1>Example headline.</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p> -->
                   <!--  <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p> -->
                  </div>
                </div>
              </div>
              <div class="carousel-item active">
                <img src="assets/images/1x/banner.png" width="1200" height="400" class="img-fluid w-100" />

                <div class="container">
                  <div class="carousel-caption">
                 <!--    <h1>Another example headline.</h1>
                    <p>Some representative placeholder content for the second slide of the carousel.</p> -->
                   <!--  <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p> -->
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <img src="assets/images/1x/banner.png" width="1200" height="400" class="img-fluid w-100" />

                <div class="container">
                  <div class="carousel-caption text-end">
                <!--     <h1>One more for good measure.</h1>
                    <p>Some representative placeholder content for the third slide of this carousel.</p> -->
                   <!--  <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p> -->
                  </div>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
            @endif
          </section>

          @yield('content')
        <footer>
          <div class="container text-center">
            <p class="text-white fs-6 fw-normal mb-1">Copyright © Department of School Education,</p>
            <p class="text-white fs-6 fw-normal mb-0">Andhra Pradesh</p>
          </div>
        </footer>
<!-- header code ends here -->
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script >

  $('#owl-carousel').owlCarousel({
    loop:true,
      margin:20,
      responsiveClass:true,
      responsive:{
          0:{
              items:1,
              nav:true
          },
          600:{
              items:3,
              nav:false
          },
          1000:{
              items:4,
              nav:true,
              loop:false
          }
      }
  })

  </script>
</html>