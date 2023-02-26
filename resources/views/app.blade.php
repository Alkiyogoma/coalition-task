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
    <meta name="description"
        content="STEAM Generation Recoveries LTD ">

    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@STEAMGeneration">
    <meta name="twitter:title" content="STEAM Generation Recoveries LTD by STEAM Generation">
    <meta name="twitter:description"
        content="STEAM Generation Recoveries LTD">
    <meta name="twitter:creator" content="@STEAMGeneration">
  
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="STEAM Generation Recoveries LTD by STEAM Generation" />
    <meta property="og:type" content="article" />
   <meta property="og:description"
        content="STEAM Generation Recoveries LTD" />
    <meta property="og:site_name" content="STEAM Generation" />

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="/assets/js/fonts.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="/assets/css/material-dashboard.min.css" rel="stylesheet" />

    <link href="{{ URL::asset('assets/css/toastr.min.css') }}" rel="stylesheet">

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
                <img src="/assets/images/logo.jpg" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">STEAM Generation </span> 
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item mb-2 mt-0">
                    <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white"
                        aria-controls="ProfileNav" role="button" aria-expanded="false">
                        <img src="/assets/img/team-3.jpg" class="avatar">
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
                                <a class="nav-link text-white" href="/tasks">
                                  <i class="material-icons text-lg me-2">layers</i>
                                    <span class="sidenav-normal  ms-3  ps-1"> My Tasks </span>
                                </a>
                            {{-- <li class="nav-item">
                                    <a class="nav-link text-white" href="/account">
                                        <span class="sidenav-mini-icon"> S </span>
                                        <span class="sidenav-normal  ms-3  ps-1"> Settings </span>
                                    </a>
                            </li> --}}
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
                <li class="nav-item">
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
                                  href="/Modal"
                                 >
                                  <span class="sidenav-mini-icon"> M </span>
                                  <span class="sidenav-normal  ms-2  ps-1"> Materials </span>
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
                                    href="/partners"
                                   >
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Partiners </span>
                                </a>
                            </li>
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
                            <li class="nav-item ">
                                <a class="nav-link text-white"
                                    href="/popovers"
                                   >
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Letters </span>
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
                                <a class="nav-link text-white" href="/pricing-page">
                                    <span class="sidenav-mini-icon"> W </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> View Depts </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/rtl-page">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Payments </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/widgets">
                                    <span class="sidenav-mini-icon"> I </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Installments </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link text-white" href="/charts">
                                    <span class="sidenav-mini-icon"> S </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Import&Export </span>
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
                                href="/messages"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> New Message </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/notifications"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> Sent Messages </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/navbar"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> Set Reminders </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white"
                                href="/pagination"
                               >
                                <span class="sidenav-normal  ms-2  ps-1"> View Report </span>
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
                <li class="nav-item">
                  <a class="nav-link"
                      href="/profile"
                     >
                      <i class="material-icons opacity-10">person</i>
                      <span class="nav-link-text ms-2 ps-1">My Profile</span>
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
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-8" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex">
                  <div class="input-group input-group-outline">
                      <label class="form-label">Search here</label>
                      <input type="text" class="form-control">
                  </div>
              </div>
              <ul class="navbar-nav  justify-content-end">
                  <li class="nav-item">
                      <a href="/profile"
                          class="nav-link text-body p-0 position-relative">
                          <i class="material-icons me-sm-1">
                              account_circle
                          </i>
                      </a>
                  </li>
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
                              notifications
                          </i>
                          <span
                              class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                              <span class="small">11</span>
                              <span class="visually-hidden">unread notifications</span>
                          </span>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4"
                          aria-labelledby="dropdownMenuButton">
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">email</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Check new messages
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li class="mb-2">
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">podcasts</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Manage podcast session
                                          </h6>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li>
                              <a class="dropdown-item border-radius-md" href="javascript:;">
                                  <div class="d-flex align-items-center py-1">
                                      <span class="material-icons">shopping_cart</span>
                                      <div class="ms-2">
                                          <h6 class="text-sm font-weight-normal my-auto">
                                              Payment successfully completed
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
      @inertia
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
                    <h5 class="mt-3 mb-0">Latest  Notifications</h5>
                    <p>See Your Activities.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            </div>
        <?php
        $tasks = \App\Models\Task::whereNotIn('status_id', [2])->orderBy('id', 'desc')->limit(4)
        ->get();
        // ->map(fn ($pay) => [
        //     'id' => $pay->id,
        //     'uuid' => $pay->uuid,
        //     'name' => $pay->title,
        //     'about' => $pay->about,
        //     'date' => date('d M, Y', strtotime($pay->task_date)),
        //     'time' => timeAgo($pay->created_at),
        //     'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
        //     'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
        //     'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
        //     'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
        //     'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
        //     'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
        // ])
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
    <script src="/assets/js/plugins/fullcalendar.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>

    <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/material-dashboard.min.js"></script>

<script>
    $(document).ready(function() {
  @if(session()->has('success'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session()->get('success') }}");
  @endif

  @if(session()->has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session()->get('error') }}");
  @endif

  @if(session()->has('info'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.info("{{ session()->get('info') }}");
  @endif

  @if(session()->has('warning'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.warning("{{ session()->get('warning') }}");
  @endif
});

</body>

</html>
