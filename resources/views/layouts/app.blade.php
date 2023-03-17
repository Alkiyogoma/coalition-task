<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/logo.jpg">
    <link rel="icon" type="image/jpg" href="/assets/images/logo.jpg">
    <title>
      STEAM Generation Recoveries LTD
    </title>


    <link rel="canonical" href="https://www.steamtz.com" />

    <meta name="keywords"
        content="STEAM Generation, Albogast, Kiyogoma, CRM, Tanzania Developer, Albogast, STEAM, Generation, Recoveries">
    <meta name="description" content="STEAM Generation Recoveries LTD ">

    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@STEAMGeneration">
    <meta name="twitter:title" content="STEAM Generation Recoveries LTD by STEAM Generation">
    <meta name="twitter:description"
        content="STEAM Generation Recoveries LTD">
    <meta name="twitter:creator" content="@STEAMGeneration">
  
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="STEAM Generation Recoveries LTD by STEAM Generation" />
    <meta property="og:type" content="article" />
   <meta property="og:description" content="STEAM Generation Recoveries LTD" />
    <meta property="og:site_name" content="STEAM Generation" />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="/assets/js/fonts.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="/assets/css/material-dashboard.min.css" rel="stylesheet" />
    <script src="/assets/js/jquery-3.6.3.min.js"></script>

    <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ URL::asset('assets/css/select2.min.js') }}"></script>
    

    <script type="text/javascript" src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>
    <link href="{{ URL::asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <style>
        .async-hide {
            opacity: 0 !important
        }

    </style>
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
                <img src="/assets/images/logo.jpg" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">STEAM Generation </span> 
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
            @if(Auth::User()->role_id == 1 || Auth::User()->role_id ==2)
                <li class="nav-item mb-2 mt-0">
                    <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white"
                        aria-controls="ProfileNav" role="button" aria-expanded="false">
                        <img src="/<?= !Auth::check() && Auth::User()->sex == 'Female' ? 'assets/img/team-3.jpg' : 'assets/img/drake.jpg' ?>" class="avatar">
                        <span class="nav-link-text ms-2 ps-1">{{ !Auth::check() ? 'Staff Profile' : Auth::User()->name }}</span>
                    </a>
                    <div class="collapse" id="ProfileNav">
                        <ul class="nav ">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/profile">
                                    <i class="material-icons text-lg me-2">person</i>
                                    <span class="sidenav-normal  ms-3  ps-1"> My Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/mytasks">
                                  <i class="material-icons text-lg me-2">layers</i>
                                    <span class="sidenav-normal  ms-3  ps-1"> My Tasks </span>
                                </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      {{ csrf_field() }}
                              </form>
                              <i class="material-icons text-lg me-2">lock</i>
                                    <span class="sidenav-normal  ms-3  ps-1"> Logout </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <hr class="horizontal light mt-0">
                {{-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-white"
                        aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                        <i class="material-icons-round opacity-10">dashboard</i>
                        <span class="nav-link-text ms-2 ps-1">Dashboards</span>
                    </a>
                    <div class="collapse " id="dashboardsExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/crm">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Analytics </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/">
                                    <span class="sidenav-mini-icon"> D </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Discover </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/partners">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Partners </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                --}}
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#componentsStaffs" class="nav-link text-white"
                      aria-controls="componentsStaffs" role="button" aria-expanded="false">
                      <i class="material-icons opacity-10">table_view</i>
                      <span class="nav-link-text ms-2 ps-1">Company</span>
                  </a>
                  <div class="collapse " id="componentsStaffs">
                      <ul class="nav ">
                         
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/departments"
                               >
                                  <span class="sidenav-mini-icon"> D </span>
                                  <span class="sidenav-normal  ms-2  ps-1"> Departments </span>
                              </a>
                          </li>
                          <li class="nav-item ">
                              <a class="nav-link text-white"
                                  href="/users"
                                 >
                                  <span class="sidenav-mini-icon"> E </span>
                                  <span class="sidenav-normal  ms-2  ps-1"> Employees </span>
                              </a>
                          </li>
                          <li class="nav-item ">
                              <a class="nav-link text-white"
                                  href="/tasks"
                                 >
                                  <span class="sidenav-mini-icon"> T </span>
                                  <span class="sidenav-normal  ms-2  ps-1"> Staff Tasks </span>
                              </a>
                          </li>
                          <li class="nav-item ">
                              <a class="nav-link text-white"
                                  href="/roles"
                                 >
                                  <span class="sidenav-mini-icon"> M </span>
                                  <span class="sidenav-normal  ms-2  ps-1"> Permissions </span>
                              </a>
                          </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#componentsCustomers" class="nav-link text-white"
                        aria-controls="componentsCustomers" role="button" aria-expanded="false">
                        <i
                        class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">apps</i>
                        <span class="nav-link-text ms-2 ps-1">Customers</span>
                    </a>
                    <div class="collapse " id="componentsCustomers">
                        <ul class="nav ">
                         
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/clients"
                                   >
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Clients </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/collections"
                                   >
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Payments </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/partners"
                                   >
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Partiners </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/branches"
                                   >
                                    <span class="sidenav-mini-icon"> B </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Branches </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/branches/employee"
                                   >
                                    <span class="sidenav-mini-icon"> E </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Employers </span>
                                </a>
                            </li>
                        
                        </ul>
                    </div>
                </li>
  
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link text-white"
                        aria-controls="pagesExamples" role="button" aria-expanded="false">
                        <i class="material-icons opacity-10">store</i>
                        <span class="nav-link-text ms-2 ps-1">Cases</span>
                    </a>
                    <div class="collapse " id="pagesExamples">
                        <ul class="nav ">
                          
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/clients/user/{{ Auth::User()->id }}">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Customers </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/today">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Today Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/week">
                                    <span class="sidenav-mini-icon"> W </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Weekly Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/month">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Monthly Report </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
          
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#componentsCases" class="nav-link text-white"
                    aria-controls="componentsCases" role="button" aria-expanded="false">
                    <i class="material-icons text-lg position-relative">email</i>
                    <span class="nav-link-text ms-2 ps-1">Messages</span>
                </a>
                <div class="collapse " id="componentsCases">
                    <ul class="nav ">
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/sendmessage"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> New Message </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/sent"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> Sent Messages </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/inbox">
                                <span class="sidenav-normal  ms-2  ps-1"> Set Reminders </span>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/#">
                                <span class="sidenav-normal  ms-2  ps-1"> Print Letters </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/templates">
                                <span class="sidenav-normal  ms-2  ps-1"> Templates </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
             
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#componentsAccounts" class="nav-link text-white"
                    aria-controls="componentsAccounts" role="button" aria-expanded="false">
                    <i class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
                    <span class="nav-link-text ms-2 ps-1">Accounts</span>
                </a>
                <div class="collapse " id="componentsAccounts">
                    <ul class="nav ">
                      
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/expenses">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Expenses </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/revenues"
                               >
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Revenues </span>
                            </a>
                        </li>
                    
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/invoices">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Invoices </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/reports"
                               >
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1">Reports </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/groups"
                               >
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Groups </span>
                            </a>
                        </li>
                    </ul>
                </div>
              </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#componentsExamples" class="nav-link text-white"
                        aria-controls="componentsExamples" role="button" aria-expanded="false">
                        <i
                            class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">view_in_ar</i>
                        <span class="nav-link-text ms-2 ps-1">Reports</span>
                    </a>
                    <div class="collapse " id="componentsExamples">
                        <ul class="nav ">
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/reports"
                                   >
                                    <span class="sidenav-mini-icon"> GR </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> General Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/partners"
                                   >
                                    <span class="sidenav-mini-icon"> PR </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Pre Invoices </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/billing"
                                   >
                                    <span class="sidenav-mini-icon"> MR </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Monthly Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/pagination"
                                   >
                                    <span class="sidenav-mini-icon"> MP </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Monthly Prospects </span>
                                </a>
                            </li>
                            
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/pagination"
                                   >
                                    <span class="sidenav-mini-icon"> MP </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Monthly Prospects </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link text-white" href="/payments">
                        <i class="material-icons-round opacity-10">home</i>
                        <span class="nav-link-text ms-2 ps-1"> Dashboard </span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white" href="/clients/user/{{ Auth::User()->id }}">
                        <i class="material-icons-round opacity-10">supervisor_account</i>
                        <span class="nav-link-text ms-2 ps-1">Customers</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="/collections/0/{{ Auth::User()->id }}">
                        <i class="material-icons-round opacity-10">dashboard</i>
                        <span class="nav-link-text ms-2 ps-1">Payments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/mytasks">
                        <i class="material-icons-round opacity-10">grading</i>
                        <span class="nav-link-text ms-2 ps-1"> My Tasks </span>
                    </a>
                </li>
                
               
                @endif
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link text-white"
                        aria-controls="pagesExamples" role="button" aria-expanded="false">
                        <i class="material-icons opacity-10">store</i>
                        <span class="nav-link-text ms-2 ps-1">Reports</span>
                    </a>
                    <div class="collapse " id="pagesExamples">
                        <ul class="nav ">
                          
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/collections">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-2  ps-1">  Collections </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/today">
                                    <span class="sidenav-mini-icon"> T </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Today Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/week">
                                    <span class="sidenav-mini-icon"> W </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Weekly Report </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/comments/month">
                                    <span class="sidenav-mini-icon"> M </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Monthly Report </span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-8" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex">
                  <div class="input-group input-group-outline">
                      <label class="form-label">Search here</label>
                      <input type="text" id="search_here" class="form-control">
                  </div>
              </div>
              <ul class="navbar-nav  justify-content-end">
                 
                  <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                          <div class="sidenav-toggler-inner">
                              <i class="sidenav-toggler-line"></i>
                              <i class="sidenav-toggler-line"></i>
                              <i class="sidenav-toggler-line"></i>
                          </div>
                      </a>
                  </li>
                  <li class="nav-item px-3">
                      <a href="javascript:;" class="nav-link text-body p-0">
                          <i class="material-icons fixed-plugin-button-nav cursor-pointer">
                              layers
                          </i>
                      </a>
                  </li>
                  <li class="nav-item dropdown pe-2">
                      <a href="javascript:;" class="nav-link text-body p-0 position-relative"
                          id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="material-icons cursor-pointer">
                            account_circle
                          </i>
                          <!-- <span
                              class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                              <span class="small">11</span>
                              <span class="visually-hidden">unread notifications</span>
                          </span> -->
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4"
                          aria-labelledby="dropdownMenuButton">
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="/profile">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">account_circle</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                            Profile
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="/collections">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">payments</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                            Collections
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">email</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Messages
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="/mytasks">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">layers</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              My Tasks
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="/calendar">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">podcasts</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Calendar
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          
                          <li>
                              <a class="dropdown-item border-radius-md" href="/clients/user/{{ Auth::User()->id }}">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">shopping_cart</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Customers
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">lock</span>
                                      <div class="ms-2">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Logout
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
                
        @if(session()->has('error') || session()->has('urls'))
            <div class="alert alert-primary alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ session()->get('error') }} <a href="{{ session()->get('urls') }}" class="alert-link text-white">Open Link</a>.</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-dark alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ session()->get('success') }}</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('message'))
        <div class="alert alert-info alert-dismissible text-white" role="alert">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ session()->get('message') }}
            </div>
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="alert alert-warning alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ session()->get('warning') }}.</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(session()->has('secondary'))
        <div class="alert alert-success alert-dismissible show fade alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert alert-dismissible show fade">
                    <span>&times;</span>
                </button>
                {{ session()->get('secondary') }}
            </div>
        </div>
        @endif

        <div id="search_result" style="display: none;" class="min-w-0 mt-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">

        </div>
        @yield('content')

    </div>
    </main>
    <div id="bottom-icon" class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            {{-- <i class="material-icons py-2">settings</i> --}}
            <i class="material-icons py-2">
              notifications
          </i>
        </a>
        <div class="card bg-gradient-dark">
          <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-1 mb-0">Latest  Notifications</h5>
                    <p>See Your Activities.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            </div>
        <?php
        $tasks = \App\Models\Task::where('user_id', Auth::User()->id)->orderBy('id', 'desc')->limit(5)
        ->get();
        ?>
            <hr class="horizontal dark my-1">
            <div class="card-body p-3">
              <div class="timeline timeline-dark timeline-one-side" data-timeline-axis-style="dotted">
                  @foreach ($tasks as $task)
                  <div v-for="task in alltasks" :key="task.id" class="timeline-block">
                                <span class="timeline-step bg-dark p-3">
                                    <i class="material-icons text-white text-sm opacity-10">
                                        notifications
                                    </i>
                                </span>
                                <div class="timeline-content pt-1">
                                    <h6 class="text-white text-sm font-weight-bold mb-0">{{  $task->title }} - {{ !empty($task->tasktype) ? $task->tasktype->name : 'Followup' }}</h6>
                                    <p class="text-secondary text-xs mt-1 mb-0">{{  !empty($task->client) ? $task->client->name : 'Not Defined' }} - {{  date('d M, Y', strtotime($task->task_date)), }}</p>
                                    <p class="text-sm text-white">
                                        {{ $task->about }}
                                        <br> Status - {{ $task->taskstatus->name }}
                                    </p>
                                </div>
                            </div>
                  @endforeach
                  
              </div>
          </div>
          
        </div>
    </div>

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

    results = function () {
        $('#search_here').keyup(function () {
            var q = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?= url('/searchs') ?>",
                data: "q=" + q,
                dataType: "html",
                success: function (data) {
                    $('#search_result').html(data).show();
                }
            });
        });
    }
$(document).ready(results);

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
