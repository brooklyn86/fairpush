<!doctype html>
<html lang="en">

<head>
<title>Login</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="">
<meta name="author" content="">

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
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="top">
                        <img src="#" alt="FairConsultoria">
                    </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">Digite seu email e senha</p>
                        </div>
                        <div class="body">
                            <?php
                                if(Session::has('erro')){
                                    echo '<div class="alert alert-danger">'.Session::get('erro').'</div>';
                                }

                                if(Session::has('sucesso')){
                                    echo '<div class="alert alert-success">'.Session::get('sucesso').'</div>';
                                }
                            ?>
                            <form class="form-auth-small" action="{{ url('app/login') }}" id="form1" method="POST">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                    <input type="email" class="form-control" id="signin-email" name="email" placeholder="Digite o email">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Senha</label>
                                    <input type="password" class="form-control" id="signin-password" name="password" placeholder="Digite sua senha">
                                </div>
                                <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Lembre-me</span>
                                    </label>
                                </div>

                                <button type="button" class="btn btn-primary btn-lg btn-block" id="btn1">LOGIN</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ url('app/esqueceu-senha') }}">Esqueceu sua senha?</a></span>

                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->

    <script src="/assets/bundles/libscripts.bundle.js"></script>
    <script src="/assets/bundles/vendorscripts.bundle.js"></script>

    <script type="text/javascript">
        $(document).ready(function(e){
            $('#btn1').click(function(e){
                $(this).attr('disabled', 'disabled');
                $('#form1').submit();
            });
        });
    </script>
</body>
</html>
