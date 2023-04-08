<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/logo.webp">
    <link rel="icon" type="image/jpg" href="/assets/images/logo.webp">
    <title>
        Simple Laravel web application for task management:
    </title>


    <link rel="canonical" href="https://www.steamtz.com" />
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="/assets/js/fonts.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="/assets/css/material-dashboard.min.css" rel="stylesheet" />

    <link href="{{ URL::asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
    <script src="/assets/js/jquery-3.6.3.min.js"></script>
    <script src="/assets/css/select2.min.js"></script>


    <style>
        .async-hide {
            opacity: 0 !important
        }

    </style>
       <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
       <script src="{{ mix('/js/app.js') }}" defer></script>
   @inertiaHead
</head>

<body class="g-sidenav-show  bg-white">

    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-dark"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0"
                href="/dashboard"
               >
               
                <img src="/assets/images/logo.webp" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white"> Task Management </span> 
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
         
                <li class="nav-item">
                    <a class="nav-link text-white" href="/">
                        <i class="material-icons-round opacity-10">home</i>
                        <span class="nav-link-text ms-2 ps-1"> Dashboard </span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white" href="/tasks">
                        <i class="material-icons-round opacity-10">task</i>
                        <span class="nav-link-text ms-2 ps-1">All Tasks</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white" href="/calendar">
                        <i class="material-icons-round opacity-10">grading</i>
                        <span class="nav-link-text ms-2 ps-1"> Calendar </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/projects">
                        <i class="material-icons-round opacity-10">dashboard</i>
                        <span class="nav-link-text ms-2 ps-1">Projects</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white" href="tasks?status_id=4&type=status_id">
                        <i class="material-icons-round opacity-10">pending_actions</i>
                        <span class="nav-link-text ms-2 ps-1"> Pending </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/tasks?status_id=2&type=status_id">
                        <i class="material-icons-round opacity-10">grading</i>
                        <span class="nav-link-text ms-2 ps-1"> Completed </span>
                    </a>
                </li>
                
              
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100">

    <nav class="navbar navbar-main navbar-expand-lg position-sticky top-0 px-0 shadow-none z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
          
          <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
              <a href="javascript:;" class="nav-link text-body p-0">
                  <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                  </div>
              </a>
          </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
    
      @inertia
    </div>
    </main>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>

    <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/material-dashboard.min.js"></script>

<script>
$(document).ready(function() {
    $('.select-single').select2();
    $('.select-multiple').select2();
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
    @if(session()->has('success'))
  		toastr.success("{{ session()->get('success') }}");
    @endif

    @if(session()->has('error'))
        toastr.error("{{ session()->get('error') }}");
    @endif

    @if(session()->has('info'))
        toastr.info("{{ session()->get('info') }}");
    @endif

    @if(session()->has('warning'))
        toastr.warning("{{ session()->get('warning') }}");
    @endif
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
</body>

</html>
