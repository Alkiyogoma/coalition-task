<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="200">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/logo.jpg">
    <link rel="icon" type="image/jpg" href="/assets/images/logo.jpg">
    <title>
        STEAM Generation Recoveries LTD
    </title>
    <link rel="canonical" href="https://www.steamtz.com" />

    <meta name="keywords" content="STEAM Generation, Albogast, Kiyogoma, CRM, Tanzania Developer, Albogast, STEAM, Generation, Recoveries">
    <meta name="description" content="STEAM Generation Recoveries LTD ">

    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@STEAMGeneration">
    <meta name="twitter:title" content="STEAM Generation Recoveries LTD by STEAM Generation">
    <meta name="twitter:description" content="STEAM Generation Recoveries LTD">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        .async-hide {
            opacity: 0 !important
        }
    </style>
</head>

<body class="g-sidenav-show  bg-white">
    <div class="container-fluid py-4">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header pb-0 mb-0">
                                    <div class="row">
                                        <div class="col-lg-6 col-7">
                                            <div class="dropdown pe-4">
                                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-secondary"></i> View
                                                </a>
                                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                                    <li><a class="dropdown-item border-radius-md" href="/staffs">This Month</a></li>
                                                    <li><a class="dropdown-item border-radius-md" href="/staffs?days=60">Last Month</a></li>
                                                    <li><a class="dropdown-item border-radius-md" href="/staffs?days=7">Last 7 days</a></li>
                                                    <li><a class="dropdown-item border-radius-md" href="/staffs?days=2">Yesterday</a></li>
                                                    <li><a class="dropdown-item border-radius-md" href="/staffs?days=1">Today</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Name</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clients</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collected</th>
                                                    <th class="text-left px-5 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($staffs as $payment)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="px-2">
                                                                <img src="/{{ $payment->sex == 'Female' ? 'assets/img/team-3.jpg' : 'assets/img/team-4.jpg' }}" class="avatar avatar-xs rounded-circle">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $payment->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $payment->client }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ money($payment->amount) }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ money($payment->total) }} </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="progress-wrapper w-75 mx-auto">
                                                            <div class="progress-info">
                                                                <div class="progress-percentage">
                                                                    <span class="text-xs font-weight-bold">{{ callPercent(round($payment->total*100/$payment->amount)) }}%</span>
                                                                </div>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-gradient-info w-{{ callPercent(round($payment->total*100/$payment->amount)) }}" role="progressbar" v-bind:aria-valuenow="`${ Math.ceil($payment->total*100/$payment->amount) }`" aria-valuemin="0" :aria-valuemax="`${ Math.ceil($payment->total*100/$payment->amount) }`"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-0">Banks Collections</h6>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                                            <i class="material-icons me-2 text-lg">date_range</i>
                                            <small>Collected</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        @foreach($partners as $partner)
                                        <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_more</i></button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">{{ $partner->name }}</h6>
                                                        <span class="text-xs"> Amount {{ money($partner->amount)  }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold ms-auto">
                                                    TZS {{ money($partner->total) }}
                                                </div>
                                            </div>
                                            <hr class="horizontal dark mt-3 mb-2" />
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header p-0">
                                <h5 class="mb-0">Latest Payments Collections</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">Collector</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Bank Name</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Account number</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($collections as $payment)
                                                <tr>
                                                    <td class="text-sm font-weight-normal">{{ $payment->collector }}</td>
                                                    <td class="text-sm font-weight-normal">{{ $payment->name }} </td>
                                                    <td class="text-sm font-weight-normal">{{ $payment->account }}</td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{ money($payment->amount) }}
                                                    </td>
                                                    <td class="text-sm font-weight-normal">{{ $payment->date }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Top Performers</h6>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        @foreach($payments as $collect)
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-1 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                    <i class="material-icons opacity-10">person</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">{{ $collect->name }}</h6>
                                                    <span class="text-xs font-weight-bold">TZS - {{ money($collect->amount) }} </span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <span class="font-weight-bold"> {{ $collect->total }}
                                                    clients</span>
                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Left and right controls -->

            <a class="carousel-control-next" href="#myCarousel" data-slide="next" style=" border-radius: 50%; height: 50px; width: 50px; margin-top: 10em; background-color: #f1f1f1;  color: black;">
                <!-- <span class="carousel-control-next-icon"></span> -->
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </section>
    <script>
        $(document).ready(function() {
            $('.select-single').select2();
            $('.select-multiple').select2();

            $('#comment').keyup(function() {
                var words = $('#comment').text().length;
                $('#word_counts').html(words);
                $('#sms_count').html(Math.ceil(words / 160));

                if (words > 475) {
                    swal("Warning!", "You have reached maximum message words limit of 480 Words ", "warning");
                }
                if (words > 160) {
                    $('#word_counts').style.color = 'black';
                }

            });
            jQuery('#source').change(function(event) {
                var source = jQuery(this).val();
                if (source === 'all' || source === '') {
                    jQuery('#families,#groups,#members,#leaders,#visitors').hide();
                } else if (source === 'groups') {
                    jQuery('#groups').show();
                    jQuery('#families,#members,#leaders,#visitors').hide();
                } else if (source === 'families') {
                    jQuery('#families').show();
                    jQuery('#groups,#members,#visitors').hide();
                } else if (source === 'visitors') {
                    jQuery('#visitors').show();
                    jQuery('#families,#groups,#leaders,#members').hide();
                } else if (source === 'members') {
                    jQuery('#members').show();
                    jQuery('#families,#groups,#leaders,#visitors').hide();
                } else if (source === 'leaders') {
                    jQuery('#leaders').show();
                    jQuery('#families,#groups,#members,#visitors').hide();
                } else {
                    jQuery('#families,#groups,#members,#leaders,#visitors').hide();
                }
            });
            jQuery('#families,#groups,#members,#leaders,#visitors').hide();
        });

        word_count = function() {
            $('#comment').keyup(function() {
                var words = $('#comment').val().length;
                $('#word_counts').html(words);
                $('#sms_count').html(Math.ceil(words / 160));
                if (words > 475) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error("You have reached maximum message words limit of 480 Words");
                }
                if (words > 160) {
                    $('#word_counts').style.color = 'black';
                }

            });
        }

        $(document).ready(word_count);

    setInterval(function() {
        window.location.reload();
    }, 200000);

    </script>


    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/material-dashboard.min.js"></script>

</body>

</html>