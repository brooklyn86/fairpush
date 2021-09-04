@section('header')
<div class="header">


    <!-- Header Title -->
    <div class="page-title-box">
        <h3>FairConsultoria</h3>
    </div>
    <!-- /Header Title -->
    @can('isAdmin')

    <ul class="nav user-menu" style="float:left !important;">
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <i class="la la-dashboard" style="font-size: 22px !important;"></i>
                </span>
                <span>Administração</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/app/setores/index">Setores</a>
                <a class="dropdown-item" href="/app/usuarios/index">Usuários</a>
                <a class="dropdown-item" href="/app/agendas/index">Tipos de Agenda</a>
                <a class="dropdown-item" href="/app/sms/index">SMS</a>
                <a class="dropdown-item" href="/app/processos-avulso">Proc. Avulso</a>
                <a class="dropdown-item" href="/app/view/taxas">Taxas</a>
                <a class="dropdown-item" href="/app/logs">Logs</a>
                <a class="dropdown-item" href="/app/estatisticas">Estatísticas</a>
            </div>
        </li>
    </ul>
    @endcan

    <!-- Header Menu -->
    <ul class="nav user-menu">
        @can('isAdmin')
        <!--<li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span>Administração</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/app/meus-dados">Meus Dados</a>
                <a class="dropdown-item" href="/app/logout">Sair</a>
            </div>
        </li>-->
        @endcan
        <!--Notifications -->
        <!-- <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notificações</span>
                    <a href="javascript:void(0)" class="clear-noti"> </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media">
                                    <span class="avatar">

                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">
                                                Nome da Pessoa</span> agendou um contato para hoje as 17:00</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="/app/minhas-notificacoes">Ver todas notificações</a>
                </div>
            </div>
        </li> -->
        <!-- /Notifications -->

        <!-- Message Notifications -->

        <!-- /Message Notifications -->

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <?php
                        $url = Storage::url(Session::get('fotoUsuario'));
                    ?>
                    <img src="{{$url}}" alt="">
                <span class="status online"></span></span>
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/app/meus-dados">Meus Dados</a>
                <a class="dropdown-item" href="/app/logout">Sair</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="/app/meus-dados">Meus Dados</a>
            <a class="dropdown-item" href="/app/logout">Sair</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
@stop

@section('sidebar')
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Menu Principal</span>
                </li>
                <li>
                    <a href="/app/dashboard"><i class="la la-home"></i> <span>Dashboard</span></a>
                </li>
                @can('isAdmin')
                <li class="submenu">
                    <a href="#"><i class="la la-lock"></i> <span> Administração</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="/app/setores/index">Setores</a></li>
                        <li><a href="/app/usuarios/index">Usuários</a></li>
                        <li><a href="/app/agendas/index">Tipos de Agenda</a></li>
                        <li><a href="/app/certificacao">Certificações</a></li>
                        <li><a href="/app/sms/index">SMS</a></li>
                    </ul>
                </li>
                @endcan
                @can('isAdmin')
                <li class="submenu">
                    <a href="#"><i class="la la-android"></i> <span> Robô</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="/app/robo/extrair-cadernos">Extrair Cadernos</a></li>
                        <li><a href="/app/robo/extrair-cadernos-antigos">Cadernos Antigos</a></li>
						<li><a href="/app/robo/antes-expedir">Antes de Expedir</a></li>
						<li><a href="/app/robo/federais">Federais</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-newspaper-o"></i> <span>Dados da plataforma</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="/app/agenda/extrair-agenda">Extrair Agenda</a></li>
                        <li><a href="/agenda/extrair-pabx">Extrair PABX</a></li>
                    </ul>
                </li>
                
                @endcan
            </ul>
        </div>
    </div>
</div>
@stop
