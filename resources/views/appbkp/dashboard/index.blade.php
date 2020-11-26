<!doctype html>
<html lang="en">

<head>
<title>Fair Concultoria</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="FairConsultoria">
<meta name="author" content="FairConsultoria">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets/vendor/animate-css/animate.min.html">

<!-- MAIN CSS -->
<link rel="stylesheet" href="/assets/css/main.css">
<link rel="stylesheet" href="/assets/css/color_skins.css">
</head>
<body class="theme-blush">

@include('app.include')
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="http://www.wrraptheme.com/templates/lucid/html/assets/images/logo-icon.svg" width="48" height="48" alt="Lucid"></div>
        <p>Carregando</p>
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">
    @yield('navbar-fixed-top')

    @yield('rightsidebar');

    @yield('mainmenu')


    <div id="main-content">
        <div class="container">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2>Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Dasboard</li>
                            <li class="breadcrumb-item active">Index</li>
                        </ul>
                    </div>



                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Stater Page</h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <h4>Stater Page</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="/assets/bundles/libscripts.bundle.js"></script>
<script src="/assets/bundles/vendorscripts.bundle.js"></script>

<script src="/assets/bundles/mainscripts.bundle.js"></script>
</body>

<script type="text/javascript">
    $(document).ready(function(e){

    })
</script>
</html>
