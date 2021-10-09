@section('navbar-fixed-top')
<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ route('app.dashboard') }}">
                <img src="http://www.wrraptheme.com/templates/lucid/html/assets/images/logo.svg" alt="FairConsultoria" class="img-responsive logo">
            </a>
        </div>

        <div class="navbar-right">
            <form id="navbar-search" class="navbar-form search-form">
                <input value="" class="form-control" placeholder="Search here..." type="text">
                <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
            </form>

            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="file-dashboard.html" class="icon-menu d-none d-md-none d-lg-block"><i class="fa fa-folder-open-o"></i></a>
                    </li>
                    <li>
                        <a href="app-calendar.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-calendar"></i></a>
                    </li>
                    <li>
                        <a href="app-chat.html" class="icon-menu d-none d-sm-block"><i class="icon-bubbles"></i></a>
                    </li>
                    <li>
                        <a href="app-inbox.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-envelope"></i><span class="notification-dot"></span></a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="notification-dot"></span>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li class="header"><strong>You have 4 new Notifications</strong></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon-info text-warning"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="text">Campaign <strong>Holiday Sale</strong> is nearly reach budget limit.</p>
                                            <span class="timestamp">10:00 AM Today</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon-like text-success"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="text">Your New Campaign <strong>Holiday Sale</strong> is approved.</p>
                                            <span class="timestamp">11:30 AM Today</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                             <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon-pie-chart text-info"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="text">Website visits from Twitter is 27% higher than last week.</p>
                                            <span class="timestamp">04:00 PM Today</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon-info text-danger"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="text">Error on website analytics configurations</p>
                                            <span class="timestamp">Yesterday</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="footer"><a href="javascript:void(0);" class="more">See all notifications</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-settings"></i></a>
                        <ul class="dropdown-menu user-menu menu-icon">
                            <li class="menu-heading">ACCOUNT SETTINGS</li>
                            <li><a href="javascript:void(0);"><i class="icon-note"></i> <span>Basic</span></a></li>
                            <li><a href="javascript:void(0);"><i class="icon-equalizer"></i> <span>Preferences</span></a></li>
                            <li><a href="javascript:void(0);"><i class="icon-lock"></i> <span>Privacy</span></a></li>
                            <li><a href="javascript:void(0);"><i class="icon-bell"></i> <span>Notifications</span></a></li>
                            <li class="menu-heading">BILLING</li>
                            <li><a href="javascript:void(0);"><i class="icon-credit-card"></i> <span>Payments</span></a></li>
                            <li><a href="javascript:void(0);"><i class="icon-printer"></i> <span>Invoices</span></a></li>
                            <li><a href="javascript:void(0);"><i class="icon-refresh"></i> <span>Renewals</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="icon-menu d-none d-sm-block rightbar_btn"><i class="icon-equalizer"></i></a>
                    </li>
                    <li>
                        <div class="user-account margin-0">
                            <div class="dropdown mt-0">
                                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                                    <img src="../assets/images/user.png" class="rounded-circle user-photo" alt="User Profile Picture">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right account">
                                    <li>
                                        <span>Welcome,</span>
                                        <strong>Alizee Thomas</strong>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="page-profile2.html"><i class="icon-user"></i>My Profile</a></li>
                                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="navbar-btn">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <i class="lnr lnr-menu fa fa-bars"></i>
            </button>
        </div>
    </div>
</nav>
@stop

@section('rightsidebar')
<div id="rightbar" class="rightbar">
    <div class="sidebar-scroll">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs-new">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Chat"><i class="icon-book-open"></i></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i class="icon-question"></i></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane animated fadeIn active" id="Chat">
                <form>
                    <div class="input-group m-b-20">
                        <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="icon-magnifier"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="right_chat list-unstyled">
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="../assets/images/xs/avatar4.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Chris Fox</span>
                                    <span class="message">Designer, Blogger</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="../assets/images/xs/avatar5.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Joge Lucky</span>
                                    <span class="message">Java Developer</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="offline">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="../assets/images/xs/avatar2.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Isabella</span>
                                    <span class="message">CEO, Thememakker</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="offline">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="../assets/images/xs/avatar1.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Folisise Chosielie</span>
                                    <span class="message">Art director, Movie Cut</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="../assets/images/xs/avatar3.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Alexander</span>
                                    <span class="message">Writter, Mag Editor</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane animated fadeIn" id="setting">
                <h6>Choose Skin</h6>
                <ul class="choose-skin list-unstyled">
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purple</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Blue</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Green</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Orange</span>
                    </li>
                    <li data-theme="blush" class="active">
                        <div class="blush"></div>
                        <span>Blush</span>
                    </li>
                </ul>
                <hr>
                <h6>General Settings</h6>
                <ul class="setting-list list-unstyled">
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Report Panel Usag</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox" checked>
                            <span>Email Redirect</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox" checked>
                            <span>Notifications</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Auto Updates</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Offline</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Location Permission</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="tab-pane animated fadeIn" id="question">
                <form>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="icon-magnifier"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="list-unstyled question">
                    <li class="menu-heading">HOW-TO</li>
                    <li><a href="javascript:void(0);">How to Create Campaign</a></li>
                    <li><a href="javascript:void(0);">Boost Your Sales</a></li>
                    <li><a href="javascript:void(0);">Website Analytics</a></li>
                    <li class="menu-heading">ACCOUNT</li>
                    <li><a href="javascript:void(0);">Cearet New Account</a></li>
                    <li><a href="javascript:void(0);">Change Password?</a></li>
                    <li><a href="javascript:void(0);">Privacy &amp; Policy</a></li>
                    <li class="menu-heading">BILLING</li>
                    <li><a href="javascript:void(0);">Payment info</a></li>
                    <li><a href="javascript:void(0);">Auto-Renewal</a></li>
                    <li class="menu-button m-t-30">
                        <a href="javascript:void(0);" class="btn btn-primary"><i class="icon-question"></i> Need Help?</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop

@section('mainmenu')
<div class="main_menu">
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <div class="navbar-collapse align-items-center collapse" id="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-speedometer"></i> Dashboard
                        </a>
                    </li>

                    <!-- <li class="nav-item dropdown mega-menu active">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="icon-docs"></i> <span>Pages</span></a>
                        <div class="dropdown-menu mega-main padding-0 animated fadeIn">
                            <div class="row">
                                <div class="col-lg-6 col-md-4 hidden-sm">
                                    <div class="img-box" style="background-image: url(../assets/images/menu-img/7.jpg)"></div>
                                </div>
                                <div class="col-lg-2 col-lg-auto col-md-4 col-sm-4">
                                    <div class="mega-list">
                                        <ul class="list-unstyled">
                                            <li><label>Pages</label></li>
                                            <li class="active"><a href="page-blank.html">Blank Page</a> </li>
                                            <li><a href="page-profile.html">Profile</a></li>
                                            <li><a href="page-profile2.html">Profile</a></li>
                                            <li><a href="page-gallery.html">Image Gallery</a> </li>
                                            <li><a href="page-gallery2.html">Image Gallery</a> </li>
                                            <li><a href="page-timeline.html">Timeline</a></li>
                                            <li><a href="page-timeline-h.html">Horizontal Timeline</a></li>
                                            <li><a href="page-pricing.html">Pricing</a></li>
                                            <li><a href="page-invoices.html">Invoices</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4">
                                    <div class="mega-list">
                                        <ul class="list-unstyled">
                                            <li><label>Pages</label></li>
                                            <li><a href="page-invoices2.html">Invoices</a></li>
                                            <li><a href="page-search-results.html">Search Results</a></li>
                                            <li><a href="page-helper-class.html">Helper Classes</a></li>
                                            <li><a href="page-teams-board.html">Teams Board</a></li>
                                            <li><a href="page-projects-list.html">Projects List</a></li>
                                            <li><a href="page-maintenance.html">Maintenance</a></li>
                                            <li><a href="page-testimonials.html">Testimonials</a></li>
                                            <li><a href="page-faq.html">FAQ</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4">
                                    <div class="mega-list">
                                        <ul class="list-unstyled">
                                            <li><label>Tables</label></li>
                                            <li><a href="table-basic.html">Tables Example</a> </li>
                                            <li><a href="table-normal.html">Normal Tables</a> </li>
                                            <li><a href="table-jquery-datatable.html">Jquery Datatables</a> </li>
                                            <li><a href="table-editable.html">Editable Tables</a> </li>
                                            <li><a href="table-color.html">Tables Color</a> </li>
                                            <li><a href="table-filter.html">Table Filter</a></li>
                                            <li><a href="table-dragger.html">Table dragger</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="icon-lock"></i> <span>Administração</span></a>
                        <ul class="dropdown-menu animated bounceIn">
                            <li><a href="{{ route('app.setores.index') }}">Setores</a></li>
                            <li><a href="{{ route('app.usuarios.index') }}">Usuários</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </div>

        </div>
    </nav>
</div>
@stop
