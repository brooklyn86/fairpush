<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Acesso FairPrice</title>

        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="/assets/js/html5shiv.min.js"></script>
			<script src="/assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body class="account-page">

		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">

				<div class="container">

					<!-- Account Logo
					<div class="account-logo">
						<a href="index.html"><img src="https://fairconsultoria.com.br/storage/settings/June2019/vVwVfttNAxE8Adwf9Uze.png"
                            alt="FairConsultoria"></a>
					</div>
					/Account Logo -->

					<div class="account-box">
						<div class="account-wrapper">
					<!-- Account Logo -->
					<div class="account-logo">
						<a href="#"><img src="https://fairconsultoria.com.br/storage/settings/June2019/vVwVfttNAxE8Adwf9Uze.png"
                            alt="FairConsultoria"></a>
					</div>
					<!-- /Account Logo -->

							<!-- <h3 class="account-title">Login</h3>
							<p class="account-subtitle">Digite o seu usuário e senha</p> -->

                            <?php
                                if(Session::has('sucesso')){
                                    echo '<div class="alert alert-success">'.Session::get('sucesso').'</div>';
                                }
                                if(Session::has('erro')){
                                    echo '<div class="alert alert-danger">'.Session::get('erro').'</div>';
                                }
                            ?>

                            <div id="showMessage"></div>


                            <div id="loginForm">
							<!-- Account Form -->
							{{ Form::open(['url' => '#', 'id' => 'form1']) }}
								<div class="form-group">
									<label>Email</label>
									{{ Form::text('email', null, ['class' => 'form-control']) }}
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col">
											<label>Senha</label>
										</div>
										<!--<div class="col-auto">
											<a class="text-muted" href="/app/esqueceu-senha">
												Esqueceu sua senha
											</a>
										</div>-->
									</div>
									{{ Form::password('password', ['class' => 'form-control']) }}
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="button" id="btn1">Entrar</button>
								</div>
								<div class="account-footer">
									<!-- <p>Don't have an account yet? <a href="register.html">Register</a></p>-->
								</div>
							</form>
                            </div>
                            <div id="mensagemAguardando">
                                <h3 class="text-info text-center">Aguardando a liberação do administrador. Em breve você será redirecionado</h3>
                            </div>
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->

        <input type="hidden" name="hidden_id">
        <script src="/assets/js/jquery-3.2.1.min.js"></script>
        <script src="/assets/js/popper.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
		<script src="/assets/js/app.js"></script>

        <script src="https://cdn.socket.io/3.1.3/socket.io.min.js" integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous"></script>
    </body>

<script type="text/javascript">
    $(document).ready(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var socket = io.connect("https://ativosalternativos.com.br:3000", {transports: ['websocket', 'polling', 'flashsocket']});

        $('#mensagemAguardando').hide();

        socket.on('eventNovoAprovado', function(data){
            console.log('eventNovoAprovado');
            console.log(data);

            if( $('input[name=hidden_id]').val() == data.id ){
                $.ajax({
                    url: '/app/login-temp',
                    method: 'POST',

                    success: function(res){
                        if(res.status == 'ok'){
                            window.location.href = '/app/dashboard';
                        }else{
                            $('#showMessage').html('<div class="alert alert-danger">Email e/ou senha incorretos. Verifique os dados digitados e tente novamente</div>');
                            $('#mensagemAguardando').hide();
                            $('#loginForm').show();
                        }
                    },error: function(err){
                        $('#showMessage').html('<div class="alert alert-danger">Ocorreu um erro ao fazer login. Tente novamente</div>');
                        $('#mensagemAguardando').hide();
                        $('#loginForm').show();
                    },complete: function(){
                        element.removeAttr('disabled');
                        element.html('Entrar');
                    }
                });
            }
        });

        socket.on('eventNovoReprovado', function(data){
            console.log('eventNovoReprovado');
            console.log(data);

            if( $('input[name=hidden_id]').val() == data.id ){
                $('#mensagemAguardando').hide();
                $('#loginForm').show();
                $('#showMessage').html('<div class="alert alert-danger">Seu login não foi aprovado pelo administrador</div>');
                alert('Seu login não foi aprovado pelo administrador');
            }
        });


        $('#btn1').click(function(e){
            var element = $(this);

            element.attr('disabled', 'disabled');
            element.html('Aguarde...');

            $.ajax({
                url: '/app/login',
                method: 'POST',
                data: {
                    email: $('input[name=email]').val(),
                    password: $('input[name=password]').val()
                },
                success: function(res){
                    console.log('sucesso');
                    console.log(res);

                    if(res.status == 'ok'){
                        $('#loginForm').hide();
                        $('#mensagemAguardando').show();
                        $('showMessage').html('');

                        socket.emit('eventLoginSucesso', { id: res.id, email: res.email, ip: res.ip, dataSolicitacao: res.dataSolicitacao });
                        $('input[name=hidden_id]').val(res.id);
                    }else{
                        $('#showMessage').html('<div class="alert alert-danger">Email e/ou senha incorretos. Verifique os dados digitados e tente novamente</div>');
                    }
                },error: function(err){
                    console.log('erro');
                    console.log(err);
                },complete: function(){
                    element.removeAttr('disabled');
                    element.html('Entrar');
                }
            });
        })
    });
</script>
</html>
