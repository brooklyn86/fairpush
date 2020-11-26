<!doctype html>
<html lang="en">

<head>
<title>Fair Concultoria</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="FairConsultoria">
<meta name="author" content="FairConsultoria">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets/vendor/animate-css/animate.min.html">

<link rel="stylesheet" href="/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/vendor/sweetalert/sweetalert.css"/>
<link rel="stylesheet" href="/assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/vendor/parsleyjs/css/parsley.css">

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
                        <h2>Setores</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Setores</li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>



                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Setores Cadastrados<small>Lista de todos os setores cadastrados</small></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <th>Título do Setor</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- <div class="form-group">
                                    <label>Email Input</label>
                                    <input type="email" class="form-control parsley-error" required="" data-parsley-id="31">
                                        <ul class="parsley-errors-list filled" id="parsley-id-31">
                                            <li class="parsley-type">This value should be a valid email.</li>
                                        </ul>
                                </div> -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Editar Setor</h4>
            </div>
            <div class="modal-body">
                <form name="formEditar" id="formEditar">
                    <div class="form-group">
                        <label>Título do Setor</label>
                        <input type="text" class="form-control" name="editarNome">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="editarStatus" class="form-control">
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnEditar">Salvar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="currentId" id="currentId">

<!-- Javascript -->
<script src="/assets/bundles/libscripts.bundle.js"></script>
<script src="/assets/bundles/vendorscripts.bundle.js"></script>

<!-- <script src="/assets/bundles/datatablescripts.bundle.js"></script>
<script src="/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="/assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="/assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="/assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<script src="/assets/vendor/sweetalert/sweetalert.min.js"></script>
<script src="/assets/vendor/toastr/toastr.js"></script>

<script src="/assets/bundles/mainscripts.bundle.js"></script>
</body>

<script type="text/javascript">
    $(document).ready(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        /*swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
        } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
    });*/
    /*var table_rows = '<tr data-id="'+res.response.id+'"><td>'+res.response.equipe+'</td><td><span class="badge badge-info">'+res.response.totalEquipe+'</span></td><td class="actions">'+
                            '<a href="#modalEditarEquipe" data-id="'+res.response.id+'" class="clickEditar success"><i class="fas fa-pencil-alt"></i></a>'+
                            '<a href="#modalExcluirEquipe" data-id="'+res.response.id+'" class="clickExcluir danger delete-row"> <i class="far fa-trash-alt"></i></a></td></tr>';

                            table.rows.add($(table_rows)).draw();*/

        $.ajax({
            url: '/app/setores/listar-todos',
            method: 'GET',
            success: function(res){
                if(res.status == 'ok'){
                    $.map( res.response, function(val, i){
                        var statusLabel = '';
                        if(val.status == 1){
                            statusLabel = '<span class="badge badge-success">Ativo</span>';
                        }else{
                            statusLabel = '<span class="badge badge-warning">Inativo</span>';
                        }

                        var botaoEditar = '<button type="button" class="btn btn-info btn-editar" title="Editar" data-id="'+val.id+'"><i class="fa fa-edit"></i></button>';
                        var botaoAtivarInativar = '';


                        var botaoExcluir = '';

                        if(val.isDeletable == 1){
                            botaoExcluir = '<button type="button" class="btn btn-danger btn-excluir" title="Excluir" data-id="'+val.id+'"><i class="fa fa-trash-o"></i></button>';
                        }


                        var row = '<tr data-id="'+val.id+'"><td>'+val.nome+'</td><td>'+statusLabel+'</td><td> '+botaoEditar+' '+botaoAtivarInativar+' '+botaoExcluir+'</td></tr>';
                        table.rows.add($(row)).draw();
                    });
                }else{
                    swal("Erro ao consultar", "Ocorreu um erro ao consultar os dados. Atualize a página e tente novamente","error");
                }
            },error: function(err){
                swal("Erro ao consultar", "Ocorreu um erro ao consultar os dados. Atualize a página e tente novamente","error");
            },complete: function(){

            }
        });

        /* Açoes */
        $('body').on('click', '.btn-editar', function(e){
            var id = $(this).attr('data-id');

            $.ajax({
                url: '/app/setores/view/' + id,
                method: 'GET',
                success: function(res){
                    if(res.status == 'ok'){
                        $('#modalEditar').modal('show');

                        $('input[name=currentId]').val( res.response.id );
                        $('input[name=editarNome]').val( res.response.nome );
                        $('select[name=editarStatus]').val( res.response.status );
                    }else{
                        swal("Erro ao consultar", "Ocorreu um erro ao consultar os dados. Atualize a página e tente novamente","error");
                    }
                },error: function(err){
                    swal("Erro ao consultar", "Ocorreu um erro ao consultar os dados. Atualize a página e tente novamente","error");
                },complete: function(){

                }
            });
        });

        $('#btnEditar').click(function(e){
            var element = $(this);
            element.attr('disabled','disabled');
            var id = $('input[name=currentId]').val();
            limparErros();

            $.ajax({
                url: '/app/setores/editar/'+id,
                method: 'POST',
                data: {
                    editarNome: $('input[name=editarNome]').val(),
                    editarStatus: $('select[name=editarStatus]').val()
                },
                success: function(res){
                    if(res.status == 'ok'){
                        $('input[name=currentId]').val('');
                        $('input[name=editarNome]').val('');
                        $('input[name=editarStatus]').val(1);

                        swal('Sucesso', 'Dados editados com sucesso', 'success');

                        var statusLabel = '';
                        if($('select[name=editarStatus]') == 1){
                            statusLabel = '<span class="badge badge-success">Ativo</span>';
                        }else{
                            statusLabel = '<span class="badge badge-warning">Inativo</span>';
                        }

                        table.cell( 'tr[data-id='+$('input[name=currentId]').val()+']', 0 ).data( $('input[name=editarNome]').val() ).draw();
                        table.cell( 'tr[data-id='+$('input[name=currentId]').val()+']', 1 ).data( statusLabel ).draw();

                        $('#modalEditar').modal('hide');
                    }else{
                        if("editarNome" in res.error){
                            $('input[name=editarNome]').addClass('parsley-error');
                            $('input[name=editarNome]').parent().append('<ul class="parsley-errors-list filled"><li class="parsley-type">'+res.error.editarNome[0]+'</li></ul>');
                        }
                        if("editarStatus" in res.error){
                            $('input[name=editarStatus]').addClass('parsley-error');
                            $('input[name=editarStatus]').parent().append('<ul class="parsley-errors-list filled"><li class="parsley-type">'+res.error.editarStatus[0]+'</li></ul>');
                        }
                    }
                },error: function(err){
                    swal("Erro", 'Ocorreu um erro ao salvar os dados. Atualize a página e tente novamente', 'error');
                },complete: function(){
                    element.removeAttr('disabled');
                }
            });
        });

        function limparErros(){
            $('input[name=editarNome]').removeClass('parsley-error');
            $('input[name=editarNome]').parent().find('ul').remove();
            $('input[name=editarStatus]').removeClass('parsley-error');
            $('input[name=editarStatus]').parent().find('ul').remove();

            $('input[name=cadastrarNome]').removeClass('parsley-error');
            $('input[name=cadastrarNome]').parent().find('ul').remove();
            $('input[name=cadastrarStatus]').removeClass('parsley-error');
            $('input[name=cadastrarStatus]').parent().find('ul').remove();
        }
    });
</script>
</html>
