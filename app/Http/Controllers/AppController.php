<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;
use Validator;
use DB;
use Session;
use App\User;
use App\Roles;
use App\Processos;
use App\Agenda;
use App\Chat;
use App\Telefones;
use App\Emails;
use App\Taxa;
use App\Log;
use App\ArquivosProcesso;
use App\TipoAgenda;
use App\SubtipoAgenda;
use App\Cedentes;
use App\MensagemSms;
use App\Notificacoes;
use App\RoboExtracaoDetalhes;
use App\DisparoMensagem;
use App\Jobs\ProcessSms;
use \PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Yajra\Datatables\Datatables;
class AppController extends Controller
{
    public function viewMeusDados(){
        $user = Auth::user();

        $data = [
            'user' => $user
        ];

        return view('app.meus_dados', $data);
    }

    public function postMeusDados(Request $request){
        $input = $request->all();

        $rules = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'Digite o seu nome corretamente'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $user = Auth::user();
        $user->name = $input['name'];

        if($input['password'] != ''){
            $user->password = Hash::make($input['password']);
        }

        $user->save();

        return back()->with('sucesso', 'Os seus dados foram alterados com sucesso');
    }
    public function excluirCedente($id){
        $sql = Cedentes::where('id', $id)->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }
    public function viewEstatisticas(Request $request){
        $input = $request->all();

        $datainicio = '';
        $datafinal = '';
        if(isset($input['datainicio'])){
           try{
            $datainicio = $input['datainicio'];

           }catch(\Exception $e){
              $datainicio = date('Y-m-d');
           }
        }else{
           $datainicio = date('Y-m-d');
           $input['datainicio'] = date('d/m/Y');
        }

        if(isset($input['datafinal'])){
           try{
                $datafinal = $input['datafinal'];

           }catch(\Exception $e){
              $datafinal = date('Y-m-d');
           }
        }else{
           $datafinal = date('Y-m-d');
           $input['datafinal'] = date('d/m/Y');
        }

        $arrayResultados = [];
        $sql = DB::table('users')->leftJoin('roles', 'roles.id','=','users.role_id')->select('users.*', 'roles.nome as roleName')->get();
        if(count($sql) > 0){
           foreach($sql as $dados){
              //faz a soma
              $sqlSoma1 = DB::table('movimentacoes')->where('idtipo', 1)->select(DB::raw( 'count(*) as total' ))->where('idfuncionario', $dados->id)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->get();
              $sqlSoma2 = DB::table('movimentacoes')->where('idtipo', 2)->select(DB::raw( 'count(*) as total' ))->where('idfuncionario', $dados->id)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->get();
              $sqlSoma3 = DB::table('movimentacoes')->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->where('idtipo', 3)->select(DB::raw( 'count(*) as total' ))->where('idfuncionario', $dados->id)->get();
              $sqlSoma4 = DB::table('movimentacoes')->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->where('idtipo', 4)->select(DB::raw( 'count(*) as total' ))->where('idfuncionario', $dados->id)->get();
              $sqlSoma5 = DB::table('movimentacoes')->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->where('idtipo', 5)->select(DB::raw( 'count(*) as total' ))->where('idfuncionario', $dados->id)->get();

              $arrayResultados[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->roleName,
                 'soma1' => $sqlSoma1[0]->total,
                 'soma2' => $sqlSoma2[0]->total,
                 'soma3' => $sqlSoma3[0]->total,
                 'soma4' => $sqlSoma4[0]->total,
                 'soma5' => $sqlSoma5[0]->total,
                 'cor' => $dados->backgroundColor,
                 'textColor' => $dados->textColor,
                 'foto' => $dados->foto,

              ];
           }
        }

        $sqlMelhores1 = DB::table('movimentacoes')->leftJoin('users', 'users.id','=','movimentacoes.idfuncionario')->leftJoin('roles', 'roles.id','=','users.role_id')->select(DB::raw( 'count(*) as total' ), 'users.name', 'roles.nome as nameRole', 'users.id', 'users.backgroundColor')->where('idtipo', 1)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->orderBy('total', 'desc')->groupBy('idfuncionario')->get();

        $sqlMelhores2 = DB::table('movimentacoes')->leftJoin('users', 'users.id','=','movimentacoes.idfuncionario')->leftJoin('roles', 'roles.id','=','users.role_id')->select(DB::raw( 'count(*) as total' ), 'users.name', 'roles.nome as nameRole', 'users.id', 'users.backgroundColor')->where('idtipo', 2)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->orderBy('total', 'desc')->groupBy('idfuncionario')->get();

        $sqlMelhores3 = DB::table('movimentacoes')->leftJoin('users', 'users.id','=','movimentacoes.idfuncionario')->leftJoin('roles', 'roles.id','=','users.role_id')->select(DB::raw( 'count(*) as total' ), 'users.name', 'roles.nome as nameRole', 'users.id', 'users.backgroundColor')->where('idtipo', 3)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->orderBy('total', 'desc')->groupBy('idfuncionario')->get();

        $sqlMelhores4 = DB::table('movimentacoes')->leftJoin('users', 'users.id','=','movimentacoes.idfuncionario')->leftJoin('roles', 'roles.id','=','users.role_id')->select(DB::raw( 'count(*) as total' ), 'users.name', 'roles.nome as nameRole', 'users.id', 'users.backgroundColor')->where('idtipo', 4)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->orderBy('total', 'desc')->groupBy('idfuncionario')->get();

        $sqlMelhores5 = DB::table('movimentacoes')->leftJoin('users', 'users.id','=','movimentacoes.idfuncionario')->leftJoin('roles', 'roles.id','=','users.role_id')->select(DB::raw( 'count(*) as total' ), 'users.name', 'roles.nome as nameRole', 'users.id', 'users.backgroundColor')->where('idtipo', 5)->whereBetween('movimentacoes.created_at', [$datainicio.' 00:00:00', $datafinal.' 23:59:59'])->orderBy('total', 'desc')->groupBy('idfuncionario')->get();

        //order por movimentacao
        //$sqlOrdem = DB::table('movimentacoes')->select(DB::raw("count(*) as total"), 'id')->get();
        $melhores01 = [];
        $melhores02 = [];
        $melhores03 = [];
        $melhores04 = [];
        $melhores05 = [];


        if(count($sqlMelhores1) > 0){
           foreach($sqlMelhores1 as $dados){
              $melhores01[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->nameRole,
                 'soma' => $dados->total,
                 'cor' => $dados->backgroundColor
              ];
           }
        }

        if(count($sqlMelhores2) > 0){
           foreach($sqlMelhores2 as $dados){
              $melhores02[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->nameRole,
                 'soma' => $dados->total,
                 'cor' => $dados->backgroundColor
              ];
           }
        }

        if(count($sqlMelhores3) > 0){
           foreach($sqlMelhores3 as $dados){
              $melhores03[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->nameRole,
                 'soma' => $dados->total,
                 'cor' => $dados->backgroundColor
              ];
           }
        }

        if(count($sqlMelhores4) > 0){
           foreach($sqlMelhores4 as $dados){
              $melhores04[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->nameRole,
                 'soma' => $dados->total,
                 'cor' => $dados->backgroundColor
              ];
           }
        }

        if(count($sqlMelhores5) > 0){
           foreach($sqlMelhores5 as $dados){
              $melhores05[] = [
                 'idfuncionario' => $dados->id,
                 'nomeFuncionario' => $dados->name,
                 'nomeFuncao' => $dados->nameRole,
                 'soma' => $dados->total,
                 'cor' => $dados->backgroundColor
              ];
           }
        }

        $total01 = 0; $total02 = 0; $total03 = 0; $total04 = 0; $total05 = 0;
        if(count($melhores01) > 0){ foreach($melhores01 as $dados){
              $total01 = $total01 + $dados['soma'];
        } }
        if(count($melhores02) > 0){ foreach($melhores02 as $dados){
              $total02 = $total02 + $dados['soma'];
        } }
        if(count($melhores03) > 0){ foreach($melhores03 as $dados){
              $total03 = $total03 + $dados['soma'];
        } }
        if(count($melhores04) > 0){ foreach($melhores04 as $dados){
              $total04 = $total04 + $dados['soma'];
        } }
        if(count($melhores05) > 0){ foreach($melhores05 as $dados){
              $total05 = $total05 + $dados['soma'];
        } }

        $data = [
           'arrayResultados' => $arrayResultados,
           'melhores01' => $melhores01,
           'melhores02' => $melhores02,
           'melhores03' => $melhores03,
           'melhores04' => $melhores04,
           'melhores05' => $melhores05,
           'total01' => $total01,
           'total02' => $total02,
           'total03' => $total03,
           'total04' => $total04,
           'total05' => $total05,
           'datainicio' => $input['datainicio'],
           'datafinal' => $input['datafinal']
        ];

        return view('app.estatisticas.index', compact('data'));
     }

    public function viewRedirectApi(Request $request){
        $input = $request->all();

        //dd($input['code']);
        /*
            ClienteID = cf00d760354dfe4b8eab638ba810f667
            ClienteSecret = QzN0gGZsAJzRB50eVgdPnw==
        */
        /*
        https://auth.jive.com/oauth2/v2/grant?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&scope=Perfil%20Jive&state=novoapp

        https://auth.jive.com/oauth2/v2/grant?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667
  &redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&scope=Jive&state=novoapp

        */

        if(isset($input['code'])){
            $response = Curl::to('https://authentication.logmeininc.com/oauth/token')
                ->withHeader('Authorization: Basic Y2ZjZDBkMGUtMzEyZi00N2U1LThhOTYtMzNlNDAyNDhhNTMwOlF6TjBnR1pzQUp6UkI1MGVWZ2RQbnc9PQ==')
                ->withContentType('application/x-www-form-urlencoded')
                ->withData([
                    'grant_type' => 'authorization_code',
                    'client_id' => "cf00d760354dfe4b8eab638ba810f667",
                    'code' => $input['code'],
                    'redirect_uri' => 'https://novoapp.fairconsultoria.com.br/redirect-api',
                 ])->post();

            $response = json_decode($response);

            if(isset($response->access_token) && isset($response->refresh_token)){
                $sql = DB::table('token')->where('iduser', Auth::user()->id)->get();

                if(count($sql) > 0){
                    DB::table('token')->where('iduser', Auth::user()->id)->update([
                        'access_token' => $response->access_token,
                        'refresh_token' => $response->refresh_token
                    ]);
                }else{
                    DB::table('token')->insert([
                        'access_token' => $response->access_token,
                        'refresh_token' => $response->refresh_token,
                        'iduser' => Auth::user()->id
                    ]);
                }

                return redirect('app/dispara-ligacao?telefone='.$input['state'].'');
            }else{
                echo '<p>Não tem access token</p>';
            }
        }
    }
    public function postCadastrarCedente(Request $request){
        $input = $request->all();

        $cedente = new Cedentes;
        $cedente->nome = $input['mccNomeCedente'];
        $cedente->nacionalidade = $input['mccNacionalidade'];
        $cedente->estado_civil = $input['mccEstadoCivil'];
        $cedente->profissao = $input['mccProfissao'];
        $cedente->cpf = $input['mccCpfCedente'];
        $cedente->rg = $input['mccRgCedente'];
        $cedente->orgao_emissor = $input['mccOrgaoEmissorRgCedente'];
        $cedente->cep = $input['mccCep'];
        $cedente->logradouro = $input['mccLogradouro'];
        $cedente->numero = $input['mccNumero'];
        $cedente->complemento = $input['mccComplemento'];
        $cedente->bairro = $input['mccBairro'];
        $cedente->cidade = $input['mccCidade'];
        $cedente->estado = $input['mccEstado'];
        $cedente->idprocesso = $input['idProcesso'];
        $cedente->banco = $input['mccBanco'];
        $cedente->agencia = $input['mccAgencia'];
        $cedente->numeroConta = $input['mccNumeroConta'];
        $cedente->tipoConta = $input['mccTipoConta'];
        $cedente->save();

        return response()->json([
            'status' => 'ok',
            'nome' => $cedente->nome,
            'nacionalidade' => $cedente->nacionalidade,
            'cpf' => $cedente->cpf,
            'rg' => $cedente->rg,
            'orgao_emissor' => $cedente->orgao_emissor,
            'id' => $cedente->id,
            'localizacao' => $cedente->cidade.' / '.$cedente->estado
        ]);
    }

    public function gerarCartaCliente(Request $request){
        $input = $request->all();
        $processo = Processos::find($request->mccidProcessoCarta);
        $nProcesso = explode('/',$processo->processo_de_origem);
        $proposta = $request->mccProposta;
        $processo->processo_de_origem = $nProcesso[0];
        $nomeDocumento = 'carta-cliente-'.$nProcesso[0].'.pdf';
        return PDF::loadView('app.pdfs.cartaCliente', compact('processo'))
        ->download($nomeDocumento);

    }

    public function getLogs( Request $request){
        $page = ($request->draw ? $request->draw : 1 );
        $offset =  $page * 100;
        $logs = Log::leftJoin('users', 'users.id','=','log.id_funcionario')
        ->leftJoin('roles', 'roles.id','=','users.role_id')
        ->leftJoin('processos', 'processos.id','=','log.id_processo');
        $totalItens = $logs->count();
        $logs->select('log.*',
        'users.name', 'roles.nome', 'processos.processo_de_origem')
        ->orderBy('log.id', 'desc');

        $itens = $logs->skip( $offset)->limit(100);

        return datatables()->of($itens)->make();

    }
    public function getLog(){

     return view('app.logs.index');
    }
    public function gerarPdfContrato(Request $request){
        $input = $request->all();

        $idprocesso = $input['idprocesso'];
        $tipo = $input['tipo'];

        /*
            1 -> Masculino
            2 -> Feminino
            3 -> Herdeiros
            4 -> plural
        */

        /* 44778 */

        if($tipo == 1){
            //processo masculino
            $sql = DB::table('orders')->where('id', $idprocesso)->get();

            $cedente = Cedentes::find($_GET['cedentes']);

            $dataAtualizacao = $_GET['dataAtualizacao'];

            $data = [
                'sql' => $sql,
                'cedente' => $cedente,
                'dataAtualizacao' => $dataAtualizacao,
                'dataLocal' => $_GET['dataLocal'],
                'valorEfetivoPago' => $_GET['valorEfetivoPago'],
                'percHonorario' => $_GET['percHonorario'],
                'campoNomesAdvs' => $_GET['campoNomesAdvs'],
                'dataAssinatura' => $_GET['dataAssinatura'],
                'campoEndAdv' => $_GET['campoEndAdv']
            ];

            $pdf = PDF::loadView('pdf.contratos.masculino_contrato_completo', $data);
            return $pdf->stream();

            /*$random = str_random(5);
            $pdf = PDF::loadView('pdf.contratos.masculino_contrato_completo', $data);
            return $pdf->download('contrato_masculino_'.date('dmY').$random.'.pdf');*/
        }elseif($tipo == 2){
            //processo masculino
            $sql = DB::table('orders')->where('id', $idprocesso)->get();

            $cedente = Cedentes::find($_GET['cedentes']);

            $dataAtualizacao = $_GET['dataAtualizacao'];

            $data = [
                'sql' => $sql,
                'cedente' => $cedente,
                'dataAtualizacao' => $dataAtualizacao,
                'dataLocal' => $_GET['dataLocal'],
                'valorEfetivoPago' => $_GET['valorEfetivoPago'],
                'percHonorario' => $_GET['percHonorario'],
                'campoNomesAdvs' => $_GET['campoNomesAdvs'],
                'dataAssinatura' => $_GET['dataAssinatura'],
                'campoEndAdv' => $_GET['campoEndAdv']
            ];

            $random = str_random(5);
            $pdf = PDF::loadView('pdf.contratos.feminino_contrato_completo', $data);
            return $pdf->download('contrato_feminino_'.date('dmY').$random.'.pdf');
        }elseif($tipo == 3){
            $cedentes = $input['cedentes'];
            $arrayCedentes = [];
            try{
                $explode = explode(',', $cedentes);

                foreach($explode as $cedente){
                    $sqlCedentes = Cedentes::find($cedente);
                    $arrayCedentes[] = $sqlCedentes;
                }
            }catch(Exception $e){

            }

            $dataAtualizacao = $_GET['dataAtualizacao'];

            $data = [
                'sql' => $sql,
                'cedente' => $cedente,
                'dataAtualizacao' => $dataAtualizacao,
                'dataLocal' => $_GET['dataLocal'],
                'valorEfetivoPago' => $_GET['valorEfetivoPago'],
                'percHonorario' => $_GET['percHonorario'],
                'campoNomesAdvs' => $_GET['campoNomesAdvs'],
                'dataAssinatura' => $_GET['dataAssinatura'],
                'campoEndAdv' => $_GET['campoEndAdv']
            ];

            /*$pdf = PDF::loadView('pdf.contratos.herdeiros_contrato_completo', $data);
            return $pdf->stream('invoice.pdf');*/
        }elseif($tipo == 4){
            $sql = DB::table('orders')->where('id', $idprocesso)->get();

            $cedentes = $input['cedentes'];
            $arrayCedentes = [];
            try{
                $explode = explode(',', $cedentes);

                foreach($explode as $cedente){
                    $sqlCedentes = Cedentes::find($cedente);
                    $arrayCedentes[] = $sqlCedentes;
                }
            }catch(Exception $e){

            }

            $dataAtualizacao = $_GET['dataAtualizacao'];

            $data = [
                'sql' => $sql,
                'cedente' => $cedente,
                'dataAtualizacao' => $dataAtualizacao,
                'dataLocal' => $_GET['dataLocal'],
                'valorEfetivoPago' => $_GET['valorEfetivoPago'],
                'percHonorario' => $_GET['percHonorario'],
                'campoNomesAdvs' => $_GET['campoNomesAdvs'],
                'dataAssinatura' => $_GET['dataAssinatura'],
                'campoEndAdv' => $_GET['campoEndAdv'],
                'arrayCedentes' => $arrayCedentes
            ];

            $random = str_random(5);
            $pdf = PDF::loadView('pdf.contratos.plural_contrato_completo', $data);
            return $pdf->download('contrato_plural_'.date('dmY').$random.'.pdf');
        }else{

        }
    }

    public function viewLogin(){
        return view('app.auth.login');
    }
    public function processoLote(Request $request){

        $input = $request->all();
        foreach($input['processos'] as $processo){
            $process = Processos::find($processo);
            if(isset($input['idFuncionario']) && $input['idFuncionario'] != ''){
                $funId = explode('-',$input['idFuncionario'] );
                $process->user_id = trim($funId[1]);
                $process->save();
            }
            if(isset($input['agendaid']) && $input['agendaid'] != ''){
                $process->idSubtipoAgenda = $input['agendaid'];
                $process->save();
            }
            $agenda = Agenda::where('processo_id',$processo)->first();
            if(isset($input['situacaoId']) && $input['situacaoId'] != ''){
                $agenda->status_id = $input['situacaoId'];
                $agenda->save();
            }else{
                $agenda->status_id = 1;
                $agenda->save();
            }
        }

        return Response()->json(['status' => 'success', 'message' => 'Pacote enviado com sucesso!']);
    }
    public function postAtualizaCPF(Request $request){
        $input = $request->all();

        $curl = curl_init();
        $token = base64_encode('arthur.curti@fairconsultoria.com.br:arthur3126294');
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.procob.com/consultas/v2/L0001/". intval($input['cpf']),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic ". $token
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $emailSave = [];
          $telefoneSave = [];
          $response = json_decode($response);

          $data_nascimento = '';
          try{
              $data_nascimento  = $response->content->nome->conteudo->data_nascimento;
                  if(!is_null($data_nascimento) || !empty($data_nascimento) || !$data_nascimento){
                      $processo = Processos::find($input['idProcesso'])->first();
                      $dt_nascimentoExplode = explode('/',$data_nascimento);
                      $data_nascimento = $dt_nascimentoExplode[2].'-'.$dt_nascimentoExplode[1].'-'.$dt_nascimentoExplode[0];
                      $processo->data_nascimento = $data_nascimento;
                      $processo->save();

                      try{
                         DB::table('movimentacoes')->insert([
                           'idfuncionario' => Auth::user()->id,
                           'idtipo' => 4,
                           'created_at' => DB::raw('now()')
                         ]);
                        }catch (\Throwable $th) {
                      }

                     }

          } catch (\Throwable $th) {
          }
          try {


            foreach($response->content->emails->conteudo as $email){
                $hasEmail = Emails::where('email', $email->email)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasEmail) || empty($hasEmail) || !$hasEmail){
                    $newemail = new Emails;
                    $newemail->email = $email->email;
                    $newemail->order_id = $input['idProcesso'];
                    $newemail->save();
                    array_push($emailSave,$newemail->toArray());
                    try {
                        DB::table('movimentacoes')->insert([
                            'idfuncionario' => Auth::user()->id,
                            'idtipo' => 4,
                            'created_at' => DB::raw('now()')
                          ]);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                }
          }

        } catch (\Throwable $th) {
            //throw $th;
        }
          try{
            foreach($response->content->pesquisa_telefones->conteudo->celular as $telefone){
                $telefoneSF = '';
                if(strlen($telefone->telefone) % 2 == 0 ){
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, strlen($telefone->telefone) / 2).'-'. substr($telefone->telefone, strlen($telefone->telefone) / 2, strlen($telefone->telefone));
                }else{
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, 5).'-'. substr($telefone->telefone, 5, strlen($telefone->telefone) );
                }
                $hasTelefone = Telefones::where('telefone', $telefoneF)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){

                    $newtelefone = new Telefones;
                    $newtelefone->telefone = $telefoneSF;
                    $newtelefone->order_id = $input['idProcesso'];
                    $newtelefone->numeroFormatado = $telefone->ddd.$telefone->telefone;
                    $newtelefone->save();
                    array_push($telefoneSave,$newtelefone->toArray());
                    try{
                        $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withData([
                                 'numero_destino' =>  $telefone->ddd.$telefone->telefone
                             ])->asJson()->post();

                             if(isset($response->dados->id)){
                                 Telefones::where('id', $newtelefone->id)->update([
                                     'callId' => $response->dados->id,
                                     'isConsultado' => '0',
                                     'returnStatus' => 'em consulta'
                                 ]);
                             }
                    }catch(\Exception $e){
                        DB::table('teste')->insert([
                            'campo1' => $e->getMessage()
                        ]);
                    }

                    try{
                       DB::table('movimentacoes')->insert([
                         'idfuncionario' => Auth::user()->id,
                         'idtipo' => 3,
                         'created_at' => DB::raw('now()')
                       ]);
                    }catch(\Exception $e){

                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
        try{
            foreach($response->content->pesquisa_telefones->conteudo->fixo as $telefone){
                $telefoneSF = '';
                if(strlen($telefone->telefone) % 2 == 0 ){
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, strlen($telefone->telefone) / 2).'-'. substr($telefone->telefone, strlen($telefone->telefone) / 2, strlen($telefone->telefone));
                }else{
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, 5).'-'. substr($telefone->telefone, 5, strlen($telefone->telefone) );
                }
                $hasTelefone = Telefones::where('telefone', $telefoneSF)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){

                    $newtelefone = new Telefones;
                    $newtelefone->telefone = $telefoneSF;
                    $newtelefone->order_id = $input['idProcesso'];
                    $newtelefone->numeroFormatado = $telefone->ddd.$telefone->telefone;
                    $newtelefone->save();
                    array_push($telefoneSave,$newtelefone->toArray());

                    try{
                        $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                            //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withData([
                                 'numero_destino' => $telefone->ddd.$telefone->telefone
                             ])->asJson()->post();

                             if(isset($response->dados->id)){
                                 Telefones::where('id', $newtelefone->id)->update([
                                     'callId' => $response->dados->id,
                                     'isConsultado' => '0',
                                     'returnStatus' => 'em consulta'
                                 ]);
                             }
                    }catch(\Exception $e){
                        DB::table('teste')->insert([
                            'campo1' => $e->getMessage()
                        ]);
                    }

                    try{
                       DB::table('movimentacoes')->insert([
                         'idfuncionario' => Auth::user()->id,
                         'idtipo' => 3,
                         'created_at' => DB::raw('now()')
                       ]);
                    }catch(\Exception $e){

                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
        try{
            foreach($response->content->pesquisa_telefones->conteudo->outros as $telefone){
                $telefoneSF = '';
                if(strlen($telefone->telefone) % 2 == 0 ){
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, strlen($telefone->telefone) / 2).'-'. substr($telefone->telefone, strlen($telefone->telefone) / 2, strlen($telefone->telefone));
                }else{
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, 5).'-'. substr($telefone->telefone, 5, strlen($telefone->telefone) );
                }
                $hasTelefone = Telefones::where('telefone',  $telefoneSF)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){

                    $newtelefone = new Telefones;
                    $newtelefone->telefone = $telefoneSF;
                    $newtelefone->order_id = $input['idProcesso'];
                    $newtelefone->numeroFormatado = $telefone->ddd.$telefone->telefone;
                    $newtelefone->save();
                    array_push($telefoneSave,$newtelefone->toArray());

                    try{
                        $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                            //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withData([
                                 'numero_destino' => $telefone->ddd.$telefone->telefone
                             ])->asJson()->post();

                             if(isset($response->dados->id)){
                                 Telefones::where('id', $newtelefone->id)->update([
                                     'callId' => $response->dados->id,
                                     'isConsultado' => '0',
                                     'returnStatus' => 'em consulta'
                                 ]);
                             }
                    }catch(\Exception $e){
                        DB::table('teste')->insert([
                            'campo1' => $e->getMessage()
                        ]);
                    }

                    try{
                       DB::table('movimentacoes')->insert([
                         'idfuncionario' => Auth::user()->id,
                         'idtipo' => 3,
                         'created_at' => DB::raw('now()')
                       ]);
                    }catch(\Exception $e){

                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
        try{
            foreach($response->content->pesquisa_telefones->conteudo->comercial as $telefone){
                $telefoneSF = '';
                if(strlen($telefone->telefone) % 2 == 0 ){
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, strlen($telefone->telefone) / 2).'-'. substr($telefone->telefone, strlen($telefone->telefone) / 2, strlen($telefone->telefone));
                }else{
                    $telefoneSF = '('.$telefone->ddd.')'.' '.substr($telefone->telefone, 0, 5).'-'. substr($telefone->telefone, 5, strlen($telefone->telefone) );
                }
                $hasTelefone = Telefones::where('telefone', $telefoneSF)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){

                    $newtelefone = new Telefones;
                    $newtelefone->telefone = $telefoneSF;
                    $newtelefone->order_id = $input['idProcesso'];
                    $newtelefone->numeroFormatado =$telefone->ddd.$telefone->telefone;
                    $newtelefone->save();
                    array_push($telefoneSave,$newtelefone->toArray());

                    try{
                        $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                            //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withData([
                                 'numero_destino' => $telefone->ddd.$telefone->telefone
                             ])->asJson()->post();

                             if(isset($response->dados->id)){
                                 Telefones::where('id', $newtelefone->id)->update([
                                     'callId' => $response->dados->id,
                                     'isConsultado' => '0',
                                     'returnStatus' => 'em consulta'
                                 ]);
                             }
                    }catch(\Exception $e){
                        DB::table('teste')->insert([
                            'campo1' => $e->getMessage()
                        ]);
                    }

                    try{
                       DB::table('movimentacoes')->insert([
                         'idfuncionario' => Auth::user()->id,
                         'idtipo' => 3,
                         'created_at' => DB::raw('now()')
                       ]);
                    }catch(\Exception $e){

                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }

          return response()->json(['emails' => $emailSave, 'telefones' => $telefoneSave, 'data_nascimento' => $data_nascimento]);
        }
    }

    public function postAtualizaScoreCPF(Request $request){
        $input = $request->all();
        $score = '';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.ph3a.com.br/DataBusca/api/Account/Login",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "UserName=cf9bb0a5-fcc4-1755-3645-8ef7b29d7721",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $emailSave = [];
          $telefoneSave = [];
          $response = json_decode($response);
          if(isset($response->data->Token)){
              $token = $response->data->Token;

              $response = Curl::to('https://api.ph3a.com.br/DataBusca/data')
                            //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withHeader('Token: '.$token)
                            ->withData([
                                 'Document' =>$input['cpf']
                             ])->asJson()->post();

                             if(isset($response->Data->CreditScore->D00)){
                                $score = $response->Data->CreditScore->D00;
                                $processo = Processos::find( $input['idProcesso']);

                                $processo->score = $response->Data->CreditScore->D00;
                                $processo->save();
                             }
          }

        try{
            foreach($response->Data->Phones as $telefone){


                $hasTelefone = Telefones::where('telefone', $telefone->FormattedNumber)->where('order_id', $input['idProcesso'])->first();
                if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){

                    $newtelefone = new Telefones;
                    $newtelefone->telefone =$telefone->FormattedNumber;
                    $newtelefone->order_id = $input['idProcesso'];
                    $newtelefone->numeroFormatado =$telefone->AreaCode.$telefone->Number;
                    $newtelefone->save();
                    array_push($telefoneSave,$newtelefone->toArray());

                    try{
                        $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                            //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                            ->withData([
                                 'numero_destino' => $telefone->AreaCode.$telefone->Number
                             ])->asJson()->post();

                             if(isset($response->dados->id)){
                                 Telefones::where('id', $newtelefone->id)->update([
                                     'callId' => $response->dados->id,
                                     'isConsultado' => '0',
                                     'returnStatus' => 'em consulta'
                                 ]);
                             }
                    }catch(\Exception $e){
                        DB::table('teste')->insert([
                            'campo1' => $e->getMessage()
                        ]);
                    }

                    try{
                       DB::table('movimentacoes')->insert([
                         'idfuncionario' => Auth::user()->id,
                         'idtipo' => 3,
                         'created_at' => DB::raw('now()')
                       ]);
                    }catch(\Exception $e){

                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }

          return response()->json(['telefones' => $telefoneSave, 'score' =>$score]);
        }
    }
    public function filterTelefone(Request $request){
        $telefone = $request->all();
        $processos = Processos::join('telefones', 'telefones.order_id','=','processos.id')
        ->where('telefones.telefone','like', '%'.$telefone['query'].'%')
        ->select('processos.*','telefones.telefone')->limit(5)->get();
        $response = [];
        foreach($processos as $processo){
            array_push($response, ['value' => $processo->reqte.' - '.$processo->telefone, 'data' => strval($processo->id)]);
        }
        return json_encode(['suggestions' => $response]);

    }

    public function filterReqte(Request $request){
        $telefone = $request->all();
        $processos = Processos::where('reqte','like', '%'.$telefone['query'].'%')->limit(5)->get();
        $response = [];
        foreach($processos as $processo){
            array_push($response, ['value' => $processo->reqte.' - '.$processo->processo_de_origem , 'data' => strval($processo->id)]);
        }
        return json_encode(['suggestions' => $response]);

    }

    public function filterCPF(Request $request){
        $telefone = $request->all();
        $processos = Processos::where('cpf','like', '%'.$telefone['query'].'%')->limit(5)->get();
        $response = [];
        foreach($processos as $processo){
            array_push($response, ['value' => $processo->cpf.' - '.$processo->processo_de_origem , 'data' => strval($processo->id)]);
        }
        return json_encode(['suggestions' => $response]);

    }

    public function filterID(Request $request){
        $id = $request->all();
        $processos = Processos::join('agenda', 'agenda.processo_id','=','processos.id')->where('processos.id','like', '%'.$id['query'].'%')->limit(5)->get();
        $response = [];
        foreach($processos as $processo){
            array_push($response, ['value' => $processo->id.' - '.$processo->processo_de_origem , 'data' => strval($processo->id)]);
        }
        return json_encode(['suggestions' => $response]);

    }

    public function filterFuncionario(Request $request){
        $telefone = $request->all();
        $users = User::where('status',1)->where('name','like', '%'.$telefone['query'].'%')->limit(5)->get();
        $response = [];
        foreach($users as $user){
            array_push($response, ['value' => $user->name .' - '. $user->id, 'data' => strval($user->id)]);
        }
        return json_encode(['suggestions' => $response]);

    }
    public function postLogin(Request $request){
        $input = $request->all();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            //Session::put('idUsuario', Auth::user()->id);
            //Session::put('fotoUsuario', Auth::user()->foto);

            Session::put('temp_email', $input['email']);
            Session::put('temp_senha', $input['password']);

            return response()->json([
                'status' => 'ok',
                'id' => Auth::user()->id,
                'email' => $input['email'],
                'ip' => $request->ip(),
                'dataSolicitacao' => date('d/m/Y').' as '.date('H:i:s'),
            ]);
            //return redirect()->route('app.dashboard');
        }
        return response()->json([
            'status' => 'erro'
        ]);
        //return redirect()->route('app.dashboard');

        //return back()->with('erro', 'Email e/ou senha incorretos');
    }

    public function postLoginTemp(){
        //$credentials = $request->only('email', 'password');
        $credentials = [
            'email' => Session::get('temp_email'),
            'password' => Session::get('temp_senha')
        ];
        if (Auth::attempt( $credentials )) {
            Session::put('idUsuario', Auth::user()->id);
            Session::put('fotoUsuario', Auth::user()->foto);

            return response()->json([
                'status' => 'ok'
            ]);
        }
        return response()->json([
            'status' => 'erro'
        ]);
    }


   public function selecionaTipoAgenda(){
        if(auth()->user()->role_id != 1){
            $tiposAgenda = TipoAgenda::where('id','!=',5)->get();
        }else{
            $tiposAgenda = TipoAgenda::all();

        }
      $arrayTiposAgenda = [];

      if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

      $data = [
         'arrayTiposAgenda' => $arrayTiposAgenda,
         'idUsuario' => Auth::user()->id,
         'role_id' => Auth::user()->role_id,
      ];

      return view('app.dashboard.seleciona_tipo_agenda', $data);
   }
   public function enviarAgendaAdmin(Request $request){

    $sql = RoboExtracaoDetalhes::find($request->id);

    if($sql == null){ returnResponse()->json(['error' => true, 'message' => 'Item não encontrado']); }

    if($sql->passou_robo != 1){
        return Response()->json(['error' => true, 'message' => 'Esse item ainda não foi atualizado pelo robô']);
    }
    if($sql->is_enviado_agenda != 0){
        return Response()->json(['error' => true, 'message' => 'Esse item já foi enviado para a agenda']);
    }


    $validador = DB::table('agenda')->leftjoin('processos', 'processos.id', '=', 'agenda.processo_id')->where('processos.cpf','=', $sql->cpf)->exists();

    if($validador){
        return Response()->json(['error' => true, 'message' => 'Existe um processo com o mesmo CPF na agenda']);

    }
    //try{
        $hasProcesso = Processos::where('processo_de_origem',  $sql->processo_de_origem)->first();
        if($hasProcesso){
            $hasProcesso->cabeca_de_acao = $sql->campo5;
            $hasProcesso->cdProcesso = $sql->cdProcesso;
            $hasProcesso->ordem_cronologica = $sql->campo3;
            $hasProcesso->exp = '';
            $hasProcesso->processo_de_origem = $sql->processo_de_origem;
            $hasProcesso->vara = $sql->campo4;
            $hasProcesso->reqte = $sql->campo5;
            $hasProcesso->advogado = $sql->campo6;
            $hasProcesso->entidade_devedora = $sql->campo7;
            $hasProcesso->cpf = $sql->cpf;
            $hasProcesso->total_condenacao = $sql->total_condenacao;
            $hasProcesso->requisitado = $sql->requisitado;
            $hasProcesso->principal_bruto = $sql->principal_bruto;
            $hasProcesso->juros_moratorio = $sql->juros_moratorio;
            $hasProcesso->natureza = $sql->natureza;
            $hasProcesso->data_base = $sql->data_base;
            $hasProcesso->idSubtipoAgenda = 5;
            $hasProcesso->data_id = 0;
            $hasProcesso->save();
        }else{
            $hasProcesso = new Processos;
            $hasProcesso->cabeca_de_acao = $sql->campo5;
            $hasProcesso->cdProcesso = $sql->cdProcesso;
            $hasProcesso->ordem_cronologica = $sql->campo3;
            $hasProcesso->exp = '';
            $hasProcesso->processo_de_origem = $sql->processo_de_origem;
            $hasProcesso->vara = $sql->campo4;
            $hasProcesso->reqte = $sql->campo5;
            $hasProcesso->advogado = $sql->campo6;
            $hasProcesso->entidade_devedora = $sql->campo7;
            $hasProcesso->cpf = $sql->cpf;
            $hasProcesso->total_condenacao = $sql->total_condenacao;
            $hasProcesso->requisitado = $sql->requisitado;
            $hasProcesso->principal_bruto = $sql->principal_bruto;
            $hasProcesso->juros_moratorio = $sql->juros_moratorio;
            $hasProcesso->natureza = $sql->natureza;
            $hasProcesso->data_base = $sql->data_base;
            $hasProcesso->idSubtipoAgenda = 5;
            $hasProcesso->data_id = 0;
            $hasProcesso->save();
        }

        $sql = RoboExtracaoDetalhes::find($request->id);
        $sql->is_enviado_agenda = 1;
        $sql->save();

        $hasAgenda = Agenda::where('processo_id',$hasProcesso->id)->first();
        if(!$hasAgenda){
            DB::table('agenda')->insert([
                'status_id' => 1,
                'processo_id' => $hasProcesso->id
            ]);
        }else{
            return Response()->json(['error' => true, 'message' => 'Esse item já foi enviado para a agenda']);
        }


        return  Response()->json(['error' => false, 'message' => 'Processo enviado para a agenda com sucesso']);

    //}catch(\Exception $e){
        dd($e->getMessage());
        return  Response()->json(['error' => true, 'message' => 'Ocorreu um erro ao enviar o processo para a agenda']);
    //}

   }

   public function enviarAgendaFederais(Request $request){

    $sql = Processos::find($request->id);

    if($sql == null){ return Response()->json(['error' => true, 'message' => 'Item não encontrado']); }

    if($sql->passou_robo != 1){
        return Response()->json(['error' => true, 'message' => 'Esse item ainda não foi atualizado pelo robô']);
    }
    if($sql->is_enviado_agenda != 0){
        return Response()->json(['error' => true, 'message' => 'Esse item já foi enviado para a agenda']);
    }


    $validador = Processos::join('agenda', 'processos.id', '=', 'agenda.processo_id')->where('processos.cpf', $sql->cpf)->exists();
    if($validador){
        return Response()->json(['error' => true, 'message' => 'Existe um processo com o mesmo CPF na agenda']);

    }
    //try{
        $hasProcesso = Processos::where('processo_de_origem',  $sql->processo_de_origem)->first();
        if($hasProcesso){
            $hasProcesso->idSubtipoAgenda = 5;
            $hasProcesso->data_id = 0;
            $hasProcesso->save();
        }

        $hasAgenda = Agenda::where('processo_id',$hasProcesso->id)->first();
        if(!$hasAgenda){
            DB::table('agenda')->insert([
                'status_id' => 1,
                'processo_id' => $hasProcesso->id
            ]);
        }else{
            return Response()->json(['error' => true, 'message' => 'Esse item já foi enviado para a agenda']);
        }


        return  Response()->json(['error' => false, 'message' => 'Processo enviado para a agenda com sucesso']);

    //}catch(\Exception $e){
        dd($e->getMessage());
        return  Response()->json(['error' => true, 'message' => 'Ocorreu um erro ao enviar o processo para a agenda']);
    //}

   }

    public function viewDashboard(Request $request){
      $input = $request->all();
        $colaboradores = User::where('status', 1)->orderBy('name','asc')->get();
        $arrayColaboradores = [];

        if(count($colaboradores) > 0){
            foreach($colaboradores as $dados){
                $arrayColaboradores[$dados->id] = $dados->name;
            }
        }
        if(auth()->user()->role_id != 1){
            $tiposAgenda = TipoAgenda::where('id','!=',5)->get();
        }else{
            $tiposAgenda = TipoAgenda::all();

        }
        $subTiposAgenda = SubtipoAgenda::all();
        $arrayTiposAgenda = [];
        $arraySubTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }
        $filtroTipoProcesso = '';
        $filtroSubtipoProcesso = '';

        if( isset($input['filtroTipoProcesso']) ){
           $filtroTipoProcesso = $input['filtroTipoProcesso'];
        }
        if( isset($input['filtroSubtipoProcesso']) ){
           $filtroSubtipoProcesso = $input['filtroSubtipoProcesso'];
        }


        $data = [
            'idUsuario' => Auth::user()->id,
            'role_id' => Auth::user()->role_id,
            'arrayColaboradores' => $arrayColaboradores,
            'arrayTiposAgenda' => $arrayTiposAgenda,
            'arraySubTiposAgenda' => $arraySubTiposAgenda,
            'filtroTipoProcesso' => $filtroTipoProcesso,
            'filtroSubtipoProcesso' => $filtroSubtipoProcesso
        ];

        return view('app.dashboard.index', $data);
    }

    public function viewSetoresIndex(){
        $sql = Roles::all();

        $data = [
            'sql' => $sql
        ];

        return view('app.setores.listar', $data);
    }

    public function ajaxListarSetores(Request $request){
        $sql = Roles::all();

        return response()->json([
            'status' => 'ok',
            'response' => $sql
        ]);
    }

    public function viewEditarSetor($id){
        $sql = Roles::find($id);

        if($sql == null){
            return back()->with('erro','Setor não encontrado');
        }

        $data = [
            'sql' => $sql
        ];

        return view('app.setores.editar', $data);
    }

    public function postEditarSetor(Request $request, $id){
        $input = $request->all();

        $rules = [
            'nome' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'nome.required' => 'Digite o título desse setor',
            'setor.required' => 'Selecione o status desse setor'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $setor = Roles::find($id);
        $setor->nome = $input['nome'];
        $setor->status = $input['status'];
        $setor->save();

        return redirect('/app/setores/index')->with('success', 'Setor editado com sucesso');
    }

    public function excluirSetor($id){
        $sql = Roles::find($id);

        if($sql == null){
            return back()->with('erro', 'Setor não encontrado');
        }

        if($sql->is_deletable == 0){
            return back()->with('erro', 'Não é possível excluir esse setor');
        }

        $users = User::where('role_id', $id)->get();

        if(count($users) > 0){
            return back()->with('erro', 'Não é possível excluir enquanto houver usuários cadastrados nesse setor');
        }

        $sql->delete();
        return back()->with('sucesso', 'O setor foi excluido com sucesso');
    }

    public function viewCadastrarSetor(){
        return view('app.setores.cadastrar');
    }

    public function postCadastrarSetor(Request $request){
        $input = $request->all();

        $rules = [
            'nome' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'nome.required' => 'Digite o título desse setor',
            'setor.required' => 'Selecione o status desse setor'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $setor = new Roles;
        $setor->nome = $input['nome'];
        $setor->status = $input['status'];
        $setor->save();

        return redirect('/app/setores/index')->with('success', 'Setor cadastrado com sucesso');
    }

    public function viewUsuarios(){
        $sql = User::leftJoin('roles', 'roles.id','=','users.role_id')->select('users.*', 'roles.nome as setor')->get();

        $data = [
            'sql' => $sql
        ];

        return view('app.usuarios.listar', $data);
    }

    public function viewCadastrarUsuario(){
        $roles = Roles::where('status', 1)->get();
        $arrayRoles = [];

        if(count($roles) > 0){
            foreach($roles as $dados){
                $arrayRoles[$dados->id] = $dados->nome;
            }
        }

        $data = [
            'arrayRoles' => $arrayRoles
        ];

        return view('app.usuarios.cadastrar', $data);
    }

    public function postCadastrarUsuario(Request $request){
        $input = $request->all();

        $rules = [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'backgroundColor' => 'required',
            'textColor' => 'required'
        ];

        $messages = [
            'name.required' => 'Digite o nome completo do usuário',
            'password.required' => 'Digite a senha de acesso desse usuário',
            'email.required' => 'Digite um endereço de email válido',
            'email.email' => 'Digite um endereço de email válido',
            'role_id.required' => 'Selecione o setor desse usuário',
            'backgroundColor.required' => 'Selecione a cor de fundo para esse usuário',
            'textColor.required' => 'Selecione a cor do texto para esse usuário'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->role_id = $input['role_id'];
        $user->status = $input['status'];
        $user->backgroundColor = $input['backgroundColor'];
        $user->textColor = $input['textColor'];

        if( $file = $request->file('foto') ){
            $fileName = Str::random(30).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $fileName);

            $user->foto = $path;
        }

        $user->save();

        return redirect('app/usuarios/index')->with('sucesso', 'Novo usuário cadastrado com sucesso');
    }

    public function viewEditarUsuario($id){
        $sql = User::find($id);

        $roles = Roles::where('status', 1)->get();
        $arrayRoles = [];

        if(count($roles) > 0){
            foreach($roles as $dados){
                $arrayRoles[$dados->id] = $dados->nome;
            }
        }

        $data = [
            'arrayRoles' => $arrayRoles,
            'sql' => $sql
        ];

        return view('app.usuarios.editar', $data);
    }


    public function getAlterarSenhaUsuarioView($id){
        $sql = User::find($id);

        return view('app.usuarios.alterarSenha', compact('sql'));
    }
    public function postAlterarSenhaUsuario(Request $request, $id){
        $input = $request->all();

        $rules = [
            'password' => 'min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'required|min:6',
        ];

        $messages = [
            'password.required' => 'Digite o nome completo do usuário',
            'cpassword.required' => 'Digite a senha de acesso desse usuário',
            'cpassword.min' => 'O Campo Confirmar Senha tem que ter no minimo 6 caracteres',
            'password.min' => 'O Campo Senha tem que ter no minimo 6 caracteres',
            'password.same' => 'O Campo Senha não está igual ao campo Confirmar Senha',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $sql = User::find($id);
        $sql->password = Hash::make($input['password']);

        $sql->save();

        return redirect('app/usuarios/index')->with('sucesso', 'Senha Atualizada com sucesso');
    }

    public function postEditarUsuario(Request $request, $id){
        $input = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.'',
            'role_id' => 'required',
            'backgroundColor' => 'required',
            'textColor' => 'required'
        ];

        $messages = [
            'name.required' => 'Digite o nome completo do usuário',
            'password.required' => 'Digite a senha de acesso desse usuário',
            'email.required' => 'Digite um endereço de email válido',
            'email.email' => 'Digite um endereço de email válido',
            'role_id.required' => 'Selecione o setor desse usuário',
            'backgroundColor.required' => 'Selecione a cor de fundo para esse usuário',
            'textColor.required' => 'Selecione a cor do texto para esse usuário'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $sql = User::find($id);
        $sql->name = $input['name'];
        $sql->email = $input['email'];
        $sql->role_id = $input['role_id'];
        $sql->status = $input['status'];
        $sql->backgroundColor = $input['backgroundColor'];
        $sql->textColor = $input['textColor'];


        if( $file = $request->file('foto') ){
            $fileName = Str::random(30).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/avatars', $fileName);

            $sql->foto = $path;
        }

        $sql->save();

        return redirect('app/usuarios/index')->with('sucesso', 'O Usuário foi editado com sucesso');
    }
    public function processosAgenda(Request $request){
        return view('app.processo_agenda.index');
    }


    public function processosAgendaLista(Request $request){
        $page = ($request->draw ? $request->draw : 1 );
        $offset =  $page * 100;
        $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
        ->leftJoin('cedentes', 'cedentes.idprocesso','=','processos.id')
        ->leftJoin('agenda_status_processo as status', 'status.id','=','agenda.status_id')
            ->select('processos.*', 'agenda.processo_id', 'processos.id as process_id', 'users.name', 'cedentes.nome', 'status.titulo')
            // ->leftJoin('dates', 'dates.id','=','processos.data_id')
            ->leftJoin('users', 'users.id','=','processos.user_id')
            ->whereNotNull('agenda.processo_id');
            $recordsTotal = $sql->count();


            $data = datatables()->of($sql)->make();
            $data->recordsTotal = $recordsTotal;
            return $data;
    }
    public function generateExcelAgenda(){
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Processo');
        $sheet->setCellValue('A2', 'Ordem Cronológica');
        $sheet->setCellValue('A3', 'Situação');
        $sheet->setCellValue('A4', 'Responsavel');
        $sheet->setCellValue('A5', 'Valor');
        $sheet->setCellValue('A6', 'Cendente');
        $sheet->setCellValue('A7', 'Advogado');
        $sheet->setCellValue('A8', 'Ent. Devedora');
        $sheet->setCellValue('A9', 'CPF');

        $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
        ->leftJoin('cedentes', 'cedentes.idprocesso','=','processos.id')
        ->leftJoin('agenda_status_processo as status', 'status.id','=','agenda.status_id')
            ->select('processos.*', 'agenda.processo_id', 'processos.id as process_id', 'users.name', 'cedentes.nome', 'status.titulo')
            // ->leftJoin('dates', 'dates.id','=','processos.data_id')
            ->leftJoin('users', 'users.id','=','processos.user_id')
            ->whereNotNull('agenda.processo_id')->get();
            $i = 0;
            for( $row = 2; $row <=$sql->count(); ++$row){
                $worksheet->getCellByColumnAndRow(1, $row)->setValue($sql[$i]['processo_de_origem']);
                $worksheet->getCellByColumnAndRow(2, $row)->setValue($sql[$i]['ordem_cronologica']);
                $worksheet->getCellByColumnAndRow(3, $row)->setValue($sql[$i]['titulo']);
                $worksheet->getCellByColumnAndRow(4, $row)->setValue($sql[$i]['name']);
                $worksheet->getCellByColumnAndRow(5, $row)->setValue(number_format($sql[$i]['principal_bruto'],2,',','.'));
                $worksheet->getCellByColumnAndRow(6, $row)->setValue(number_format($sql[$i]['juros_moratorio'],2,',','.'));
                $worksheet->getCellByColumnAndRow(7, $row)->setValue($sql[$i]['advogado']);
                $worksheet->getCellByColumnAndRow(8, $row)->setValue($sql[$i]['advogado']);
                $worksheet->getCellByColumnAndRow(9, $row)->setValue($sql[$i]['entidade_devedora']);
                $worksheet->getCellByColumnAndRow(9, $row)->setValue($sql[$i]['cpf']);
                $i++;
            }

        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('agenda.xlsx');
    }

    public function generateAgenda2(){
        
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Processo');
        $sheet->setCellValue('A2', 'Ordem Cronológica');
        $sheet->setCellValue('A3', 'Situação');
        $sheet->setCellValue('A4', 'Responsavel');
        $sheet->setCellValue('A5', 'Valor');
        $sheet->setCellValue('A6', 'Cendente');
        $sheet->setCellValue('A7', 'Advogado');
        $sheet->setCellValue('A8', 'Ent. Devedora');
        $sheet->setCellValue('A9', 'CPF');

        $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
        ->leftJoin('cedentes', 'cedentes.idprocesso','=','processos.id')
        ->leftJoin('agenda_status_processo as status', 'status.id','=','agenda.status_id')
            ->select('processos.*', 'agenda.processo_id', 'processos.id as process_id', 'users.name', 'cedentes.nome', 'status.titulo')
            // ->leftJoin('dates', 'dates.id','=','processos.data_id')
            ->leftJoin('users', 'users.id','=','processos.user_id')
            ->whereNotNull('agenda.processo_id')->get();
            $i = 0;
            for( $row = 2; $row <=$sql->count(); ++$row){
                $sheet->getCellByColumnAndRow(1, $row)->setValue($sql[$i]['processo_de_origem']);
                $sheet->getCellByColumnAndRow(2, $row)->setValue($sql[$i]['ordem_cronologica']);
                $sheet->getCellByColumnAndRow(3, $row)->setValue($sql[$i]['titulo']);
                $sheet->getCellByColumnAndRow(4, $row)->setValue($sql[$i]['name']);
                $sheet->getCellByColumnAndRow(5, $row)->setValue(number_format($sql[$i]['principal_bruto'],2,',','.'));
                $sheet->getCellByColumnAndRow(6, $row)->setValue(number_format($sql[$i]['juros_moratorio'],2,',','.'));
                $sheet->getCellByColumnAndRow(7, $row)->setValue($sql[$i]['advogado']);
                $sheet->getCellByColumnAndRow(8, $row)->setValue($sql[$i]['advogado']);
                $sheet->getCellByColumnAndRow(9, $row)->setValue($sql[$i]['entidade_devedora']);
                $sheet->getCellByColumnAndRow(9, $row)->setValue($sql[$i]['cpf']);
                $i++;
            }

        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=my_excel_filename.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $writer->save('php://output');
        // $writer->save('agenda.xlsx');
    }
    public function generateAgenda(Request $request){

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        $sql = Processos::join('agenda', 'agenda.processo_id','=','processos.id')
        ->leftJoin('telefones', 'telefones.order_id','=','processos.id')
        ->select('processos.*', 'agenda.processo_id', 'processos.id as process_id', 'telefones.telefone')
        ->where('telefones.telefone','!=', null)
        ->where('agenda.status_id','=',2)
        ->where('telefones.telefone','!=', '')
        ->whereNotNull('agenda.processo_id')->paginate(1000);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Processo');
        $sheet->setCellValue('B1', 'Requerente');
        $sheet->setCellValue('C1', 'Ent. Devedora');
        $sheet->setCellValue('D1', 'Telefone');
        $row = 2;
        foreach($sql as  $dados) {
            $sheet->getCellByColumnAndRow(1, $row)->setValue($dados['processo_de_origem']);
            $sheet->getCellByColumnAndRow(2, $row)->setValue($dados['reqte']);
            $sheet->getCellByColumnAndRow(3, $row)->setValue($dados['entidade_devedora']);
            $sheet->getCellByColumnAndRow(4, $row)->setValue($dados['telefone']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Lista de Contatos.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $writer->save('php://output');
       
    }


    public function alterarAgenda(Request $request){
        $input = $request->all();
        $rules = [
            'mccidProcessoChangeAgenda' => 'required',
            'subTipoProcesso' => 'required',
            'tipoProcesso' => 'required',
        ];
        $messages = [
            'subTipoProcesso.required' => 'Selecione o sub-Tipo da Agenda',
            'tipoProcesso.required' => 'Informe o tipo da agenda',
            'mccidProcessoChangeAgenda.required' => 'Informe o processo a ser alterado',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return response()->json(['status' => 'erro', 'error' => $validation->errors()]);
        }
        $processo = Processos::find($request->mccidProcessoChangeAgenda);
        $processo->idSubtipoAgenda = ($request->subTipoProcesso ? $request->subTipoProcesso : null );
        $processo->save();

        return response()->json($processo);
    }
    public function agendaCadastrarNovoProcesso(Request $request){
        $input = $request->all();

        if(auth()->user()->role_id == User::ADMIN){
            $rules = [
                'mnpEntidadeDevedora' => 'required',
                // 'mnpCabecaAcao' => 'required',
                'mnpNumeroProcesso' => 'required',
                'mnpValorPrincipal' => 'required',
                'mnpValorJuros' => 'required',
                'mnpColaborador' => 'required',
                'mnpSubTipoProcesso' => 'required',
                'mnpTipoProcesso' => 'required',
            ];
        }else{
            $rules = [
                // 'mnpCabecaAcao' => 'required',
                'mnpNumeroProcesso' => 'required',
                'mnpValorPrincipal' => 'required',
                'mnpValorJuros' => 'required',
                'mnpSubTipoProcesso' => 'required',
                'mnpTipoProcesso' => 'required',
            ];
        }
        $messages = [
            'mnpEntidadeDevedora.required' => 'Digite a entidade devedora',
            // 'mnpCabecaAcao.required' => 'Digite o nome do cabeça de ação',
            'mnpNumeroProcesso.required' => 'Digite o número do processo',
            'mnpValorPrincipal.required' => 'Digite o valor principal',
            'mnpValorJuros.required' => 'Digite o valor dos juros',
            'mnpColaborador.required' => 'Digite o nome do colaborador',
            'mnpSubTipoProcesso.required' => 'Selecione o Sub-tipo da Agenda',
            'mnpTipoProcesso.required' => 'Selecione o Tipo da Agenda',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return response()->json(['status' => 'erro', 'error' => $validation->errors()]);
        }

        $mnpValorPrincipal = $input['mnpValorPrincipal'];
        $mnpValorPrincipal = str_replace('.', '', $mnpValorPrincipal);
        $mnpValorPrincipal = str_replace(',', '.', $mnpValorPrincipal);

        $mnpValorJuros = $input['mnpValorJuros'];
        $mnpValorJuros = str_replace('.', '', $mnpValorJuros);
        $mnpValorJuros = str_replace(',', '.', $mnpValorJuros);

        $mnpIndiceDataBase = explode('/', $input['mnpIndiceDataBase']);

        if(isset($mnpIndiceDataBase[2], $mnpIndiceDataBase[1], $mnpIndiceDataBase[0])){
            $mnpIndiceDataBase = $mnpIndiceDataBase[2].'-'.$mnpIndiceDataBase[1].'-'.$mnpIndiceDataBase[0];
        }else{
            $mnpIndiceDataBase = '1900-01-01';
        }
        $processos = new Processos;
        $processos->entidade_devedora = $input['mnpEntidadeDevedora'];
        $processos->cabeca_de_acao = $input['mnpCabecaAcao'];
        $processos->ordem_cronologica = $input['mnpOrdemCronologica'];
        $processos->exp = $input['mnpExp'];
        $processos->processo_de_origem = $input['mnpNumeroProcesso'];
        $processos->reqte = $input['mnpRequerente'];
        $processos->cpf = $input['mnpCpf'];
        $processos->principal_bruto = $mnpValorPrincipal;
        $processos->juros_moratorio = $mnpValorJuros;
        $processos->user_id = (isset($input['mnpColaborador']) ? $input['mnpColaborador'] : auth()->user()->id);
        $processos->idSubtipoAgenda = ($request->mnpSubTipoProcesso ? $request->mnpSubTipoProcesso : null );
        // $processo->idSubtipoAgenda = ($request->mnpTipoProcesso ? $request->mnpTipoProcesso : null );
        $processos->data_base = $mnpIndiceDataBase;
        $processos->data_id = 0;
        $processos->isAvulso = 1;
        $processos->save();

        //Adiciona na Agenda
        $agenda = new Agenda;
        $agenda->status_id = 1;
        $agenda->processo_id = $processos->id;
        $agenda->save();
        if(auth()->user()->role_id == User::ADMIN){
            $sql = User::find($input['mnpColaborador']);

        }else{
            $sql = auth()->user();
        }
        DB::table('log')->insert([
            'id_funcionario' => auth()->user()->id,
            'id_processo' => $processos->idprocesso,
            'anotacao' => 'O Funcionário cadastrou um novo Processo na plataforma' ,
            'created_at' => DB::raw('now()')
         ]);

         try{
            DB::table('movimentacoes')->insert([
               'idfuncionario' => auth()->user()->id,
               'idtipo' => 1,
               'created_at' => DB::raw('now()')
            ]);
         }catch(\Exception $e){

         }
        return response()->json([
            'status' => 'ok',
            'response' => [
                'id' => $processos->id,
                'nome' => $input['mnpCabecaAcao'],
                'valor' => 'R$ '.number_format($mnpValorPrincipal,2,',','.'),
                'backgroundColor' => $sql->backgroundColor,
                'textColor' => $sql->textColor
            ]
        ]);
    }

    public function extrairAgenda(){
        return view('app.dados_plataforma.extrair_agenda');
    }
    public function getAgendaProcessos(Request $request){
        ini_set('memory_limit', '-1');
        $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
        ->select('processos.*', 'agenda.*', 'processos.id as process_id',
            'users.name')
            ->leftJoin('users', 'users.id','=','processos.user_id')
            ->whereNotNull('agenda.processo_id')->get()->toArray();
        return Datatables($sql)
        ->addColumn('juros_moratorio', function($row){
            return 'R$ '.number_format($row['juros_moratorio'],2,',','.');
        })
        ->addColumn('principal_bruto', function($row){
            return 'R$ '.number_format($row['principal_bruto'],2,',','.');
        })
        ->addColumn('nomeUser', function($row){
            if(is_null($row['name']) ){
                return 'Sem atribuição';
            }
            return $row['name'];
        })
        ->addColumn('ordem_cronologica', function($row){
            if(is_null($row['ordem_cronologica']) ){
                return 'Não Informada';
            }
            return $row['ordem_cronologica'];
        })
        ->addColumn('advogado', function($row){
            if(is_null($row['advogado']) ){
                return 'Não Informado';
            }
            return $row['advogado'];
        })
        ->addColumn('principal_bruto', function($row){
            return 'R$ '.number_format($row['principal_bruto'],2,',','.');
        })
        ->addColumn('data_abertura', function($row){
            if(!is_null($row['dataUltimaAbertura'])){
                return \Carbon\Carbon::create($row['dataUltimaAbertura'])->format('d/m/Y H:i:s');
            }else{
                return '';
            }
        })
       ->addColumn('status', function($row){
        $status = 'Sem Status';

        if($row['status_id'] == 1){
            $status = 'Novo';
        }elseif($row['status_id'] == 2){
            $status = 'Tentando Contato';
        }elseif($row['status_id'] == 3){
            $status = 'Sem Interesse';
        }elseif($row['status_id'] == 4){
            $status = 'Proposta Enviada';
        }elseif($row['status_id'] == 6){
            $status = 'Cliente Avaliando';
        }elseif($row['status_id'] == 7){
            $status = 'Parecer';
        }elseif($row['status_id'] == 8){
            $status = 'Cessão Agendada';
        }elseif($row['status_id'] == 9){
            $status = 'Pagamento Realizado';
        }

        return $status;
        })
        ->make();

    }
    public function recuperaProcessosByStatus(Request $request, $status_id){
        if($request->tipoAgenda == 5){
            try{
                $input = $request->all();
                $pdo = DB::connection()->getPdo();
                $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');
                $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
                    ->leftJoin('users','users.id','=','processos.user_id')
                    // ->leftJoin('subtipo_agenda', 'subtipo_agenda.id','=','processos.idSubtipoAgenda')
                    ->leftJoin('tipo_agenda', 'tipo_agenda.id','=','processos.idSubtipoAgenda')
                    ->select('processos.*','processos.id as processoID', 'users.backgroundColor', 'users.textColor', 'users.id as userid', 'tipo_agenda.tipoAgenda as tituloSubTipo', 'tipo_agenda.tipoAgenda as tituloTipo')
                    ->where(function($query) use ($input) {
                        if(auth()->user()->role_id != User::ADMIN){
                            $query->where('processos.user_id',auth()->user()->id);
                        }
                        if(isset($input['tipoAgenda']) && $input['tipoAgenda'] != '' && !is_null($input['tipoAgenda'])){
                            $query->where('tipo_agenda.id', $input['tipoAgenda']);
                        }
                    })
                    ->where('agenda.status_id', $status_id)->get();
                $arrayResponse = [];

                if(count($sql) > 0){
                   foreach($sql as $dados){
                      $ultimaAbertura = \Carbon\Carbon::createFromDate($dados->dataUltimaAbertura);
                      $now = \Carbon\Carbon::now();
                      $pb = number_format($dados->principal_bruto,2,'.','');
                      $ju = number_format($dados->juros_moratorio,2,'.','');
                      $dados->valorPrecatorioTotal = ($pb + $ju);
                      try {
                            $dataBase = explode('-', $dados->data_base);
                        } catch (\Throwable $th) {
                            $dataBase = '';
                        }
                      $arrayResponse[] = [
                         'id' => $dados->id,
                         'processoID' => $dados->processoID,
                         'nome' => ucwords(strtolower($dados->reqte)),
                         'iduser' => $dados->userid,
                         'userid' => $dados->userid,
                         'numeroProcesso' => $dados->processo_de_origem,
                         'principal_bruto' => $dados->principal_bruto,
                         'valorPrecatorioTotal' => $dados->valorPrecatorioTotal,
                         'valor' => ''.number_format($dados->principal_bruto,2,',','.'),
                         'valorBruto' => $dados->principal_bruto,
                         'dataBase' => $dataBase,
                         'ordem_cronologica' => $dados->ordem_cronologica,
                         'data_nascimento' => $dados->data_nascimento,
                         'backgroundColor' => $dados->backgroundColor,
                         'textColor' => $dados->textColor,
                         'abandono' => $ultimaAbertura->diffInDays($now)
                         //  'abandono' =>  $datework->diffInDays($now)
                      ];
                   }
                }
                return response()->json([
                    'status' => 'ok',
                    'response' => $arrayResponse
                ]);
            }catch(\Exception $e){
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => $e->getMessage()
                ]);
            }
        }else{
            try{
                $input = $request->all();
                $pdo = DB::connection()->getPdo();
                $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');
                $sql = Processos::leftJoin('agenda', 'agenda.processo_id','=','processos.id')
                    ->leftJoin('users','users.id','=','processos.user_id')
                    ->leftJoin('subtipo_agenda', 'subtipo_agenda.id','=','processos.idSubtipoAgenda')

                    ->leftJoin('tipo_agenda', 'tipo_agenda.id','=','subtipo_agenda.idTipoAgenda')
                    ->select('processos.*','processos.id as processoID','users.backgroundColor', 'users.textColor', 'users.id as userid', 'subtipo_agenda.titulo as tituloSubTipo', 'tipo_agenda.tipoAgenda as tituloTipo')
                    ->where(function($query) use ($input) {
                        if(auth()->user()->role_id != User::ADMIN){
                            $query->where('processos.user_id',auth()->user()->id);
                        }
                        if(isset($input['tipoAgenda']) && $input['tipoAgenda'] != '' && !is_null($input['tipoAgenda'])){
                            $query->where('tipo_agenda.id', $input['tipoAgenda']);
                        }
                        if(isset($input['subtipoAgenda']) && $input['subtipoAgenda'] != '' && !is_null($input['subtipoAgenda'])){
                            $query->where('subtipo_agenda.id', $input['subtipoAgenda']);
                        }
                    })
                    ->where('agenda.status_id', $status_id)->get();
                // dd($sql);
                $arrayResponse = [];

                if(count($sql) > 0){
                   foreach($sql as $dados){
                      $ultimaAbertura = \Carbon\Carbon::createFromDate($dados->dataUltimaAbertura);
                      $now = \Carbon\Carbon::now();
                      $pb = number_format($dados->principal_bruto,2,'.','');
                      $ju = number_format($dados->juros_moratorio,2,'.','');
                      $dados->valorPrecatorioTotal = ($pb + $ju);
                      try {
                         $dataBase = explode('-', $dados->data_base);
                      } catch (\Throwable $th) {
                         $dataBase = '';
                      }
                      $arrayResponse[] = [
                         'id' => $dados->id,
                         'processoID' => $dados->processoID,
                         'nome' => ucwords(strtolower($dados->reqte)),
                         'iduser' => $dados->userid,
                         'userid' => $dados->userid,
                         'numeroProcesso' => $dados->processo_de_origem,
                         'principal_bruto' => $dados->principal_bruto,
                         'valorPrecatorioTotal' => $dados->valorPrecatorioTotal,
                         'valor' => ''.number_format($dados->principal_bruto,2,',','.'),
                         'valorBruto' => $dados->principal_bruto,
                         'dataBase' => $dataBase,
                         'ordem_cronologica' => $dados->ordem_cronologica,
                         'data_nascimento' => $dados->data_nascimento,
                         'backgroundColor' => $dados->backgroundColor,
                         'textColor' => $dados->textColor,
                         'abandono' => $ultimaAbertura->diffInDays($now)
                      ];
                   }
                }

                return response()->json([
                    'status' => 'ok',
                    'response' => $arrayResponse
                ]);
            }catch(\Exception $e){
                return response()->json([
                    'status' => 'erro',
                    'mensagem' => $e->getMessage()
                ]);
            }
        }


    }

    public function recuperaDadoseComentariosByProcessoId($idprocesso){


        $sql = DB::table('processos')->leftJoin('agenda', 'agenda.processo_id','=','processos.id')
            ->leftJoin('subtipo_agenda', 'subtipo_agenda.id','=','processos.idSubtipoAgenda')
            ->leftJoin('tipo_agenda', 'tipo_agenda.id','=','subtipo_agenda.idTipoAgenda')
            ->select('processos.*', DB::raw("date_format(dataUltimaAbertura,'%d/%m/%Y as %H:%i:%s') as dataUltimaAberturaFormat"), 'agenda.processo_id', 'agenda.status_id', DB::raw("date_format(dataAgendamentoContato, '%d/%m/%Y') as dataAgendamento", 'cedentes.* as cendentes'),
            'descricaoAgendamento',  'subtipo_agenda.titulo as tituloSubTipo', 'tipo_agenda.tipoAgenda as tituloTipo','tipo_agenda.id as idTipo')->where('processos.id', $idprocesso)->get();
            if(count($sql) < 1){
             return response()->json([
                 'status' => 'erro'
             ]);
         }

         $cendente = DB::table('cedentes')->where('idprocesso',$sql[0]->id)->get();
         if(Auth::user()->role_id != 1){
            DB::table('processos')->where('id', $idprocesso)->update([
                'dataUltimaAbertura' => DB::raw('now()')
            ]);
         }


         $data_base = explode('-', $sql[0]->data_base);
         if(isset($data_base[0], $data_base[1], $data_base[2])){
             $data_base = $data_base[2].'/'.$data_base[1].'/'.$data_base[0];
         }else{
             $data_base = '';
         }

         $correcao_ate = explode('-', $sql[0]->correcao_ate);
         if(isset($correcao_ate[0], $correcao_ate[1], $correcao_ate[2])){
             $correcao_ate = $correcao_ate[2].'/'.$correcao_ate[1].'/'.$correcao_ate[0];
         }else{
             $correcao_ate = '';
         }

         if($sql[0]->dias_juros == ''){
             $dias_juros = 0;
         }else{
             $dias_juros = $sql[0]->dias_juros;
         }

         Notificacoes::where('idusuario', Auth::user()->id)->where('idprocesso', $idprocesso)->update([
             'foi_aberto' => 1
         ]);

         $notificacoes = Notificacoes::where('idusuario', Auth::user()->id)->where('idprocesso', $idprocesso)->where('foi_aberto', 0)
             ->leftJoin('processos', 'processos.id','=','notificacoes.idprocesso')
             ->select("notificacoes.*", 'processos.processo_de_origem', 'processos.cabeca_de_acao', DB::raw("date_format(data_agendamento, '%d/%m/%Y') as data_agendamento_format"), DB::raw("date_format(foi_aberto_em, '%d/%m/%Y') as foi_aberto_em_format"))->get();

        $arrayNotificacoes = [];
        if(count($notificacoes) > 0){
            foreach($notificacoes as $dados){
                $arrayNotificacoes[] = [
                    'id' => $dados->id,
                    'data_agendamento' => $dados->data_agendamento_format,
                    'comentario' => $dados->comentario
                ];
            }
        }

         $chat = Chat::leftJoin('users', 'users.id','=','chat.user_id')->where('idprocesso', $idprocesso)
             ->select("chat.*", 'users.name',DB::raw("date_format(chat.created_at, '%d/%m/%Y as %H:%i') as dataEnvio"))->orderBy('created_at','desc')->get();

         $arrayChat = [];
         if(count($chat) > 0){
             foreach($chat as $dados){
                 $arrayChat[] = [
                     'id' => $dados->id,
                     'name' => $dados->name,
                     'mensagem' => $dados->mensagem,
                     'dataEnvio' => $dados->dataEnvio
                 ];
             }
         }

         $sqlTelefones = Telefones::where('order_id', $idprocesso)->where('isParente',0)->get();
         $arrayTelefones = [];

         if(count($sqlTelefones) > 0){
             foreach($sqlTelefones as $dados){
                 $arrayTelefones[] = [
                     'id' => $dados->id,
                     'telefone' => $dados->telefone,
                     'returnStatus' => $dados->returnStatus,
                     'isConsultado' => $dados->isConsultado,
                     'isParente' => $dados->isParente

                 ];
             }
         }
         $sqlTelefones = Telefones::where('order_id', $idprocesso)->where('isParente',1)->get();
         $arrayTelefonesParente = [];

         if(count($sqlTelefones) > 0){
             foreach($sqlTelefones as $dados){
                 $arrayTelefonesParente[] = [
                     'id' => $dados->id,
                     'telefone' => $dados->telefone,
                     'returnStatus' => $dados->returnStatus,
                     'isConsultado' => $dados->isConsultado,
                     'isParente' => $dados->isParente

                 ];
             }
         }

         $sqlEmails = Emails::where('order_id', $idprocesso)->get();
         $arrayEmails = [];

         if(count($sqlEmails) > 0){
             foreach($sqlEmails as $dados){
                 $arrayEmails[] = [
                     'id' => $dados->id,
                     'email' => $dados->email,

                 ];
             }
         }

         $sqlDocumentos = ArquivosProcesso::where('idProcesso', $idprocesso)->select('*', DB::raw("date_format(created_at, '%d/%m/%Y as %H:%i') as dataEnvio"))->get();
         $arrayDocumentos = [];

         if(count($sqlDocumentos) > 0){
             foreach($sqlDocumentos as $dados){
                 $arrayDocumentos[] = [
                     'id' => $dados->id,
                     'tituloDocumento' => $dados->tituloDocumento,
                     'arquivo' => $dados->arquivo,
                     'dataEnvio' => $dados->dataEnvio
                 ];
             }
         }

         return response()->json([
             'status' => 'ok',
             'arrayChat' => $arrayChat,
             'arrayTelefones' => $arrayTelefones,
             'arrayTelefonesParente' => $arrayTelefonesParente,
             'arrayEmails' => $arrayEmails,
             'arrayDocumentos' => $arrayDocumentos,
             'arrayNotificacoes' => $arrayNotificacoes,
             'data_ultima_abertura' => $sql[0]->dataUltimaAberturaFormat,
             'user_id' => $sql[0]->user_id,
             'cabeca_de_acao' => $sql[0]->cabeca_de_acao,
             'cdProcesso' => $sql[0]->cdProcesso,
             'data_id' => $sql[0]->data_id,
             'order_id' => $sql[0]->processo_id,
             'ordem_cronologica' => $sql[0]->ordem_cronologica,
             'data_nascimento' => $sql[0]->data_nascimento,
             'exp' => $sql[0]->exp,
             'processo_de_origem' => $sql[0]->processo_de_origem,
             'vara' => $sql[0]->vara,
             'reqte' => $sql[0]->reqte,
             'advogado' => $sql[0]->advogado,
             'entidade_devedora' => $sql[0]->entidade_devedora,
             'cpf' => $sql[0]->cpf,
             'data' => $sql[0]->data,
             'total_condenacao' => $sql[0]->total_condenacao,
             'total_condenacao_format' => 'R$ '.number_format($sql[0]->total_condenacao, 2, ',','.'),
             'requisitado' => $sql[0]->requisitado,
             'principal_bruto' => ''.number_format($sql[0]->principal_bruto, 2, ',','.'),
             'principal_bruto_format' => ''.number_format($sql[0]->principal_bruto, 2, ',','.'),
             'juros_moratorio' => $sql[0]->juros_moratorio,
             'juros_moratorio_format' => ''.number_format($sql[0]->juros_moratorio, 2, ',','.'),
             'natureza' => $sql[0]->natureza,
             'data_base' => $data_base,
             'correcao_ate' => $correcao_ate,
             'inicio_data_base_taxa' => $sql[0]->inicio_data_base_taxa,
             'inicio_correcao_taxa' => $sql[0]->inicio_correcao_taxa,
             'dias_juros' => $dias_juros,
             'percentual_ass_med' => $sql[0]->percentual_ass_med,
             'pagamento_parcias' => $sql[0]->pagamento_parcias,
             'cessao_sem_honorario' => $sql[0]->cessao_sem_honorario,
             'pagamento_cessao' => $sql[0]->pagamento_cessao,
             'previdencia_ativo' => $sql[0]->previdencia_ativo,
             'user_id' => $sql[0]->user_id,
             'dataAgendamento' => $sql[0]->dataAgendamento,
             'descricaoAgendamento' => $sql[0]->descricaoAgendamento,
             'status_id' => $sql[0]->status_id,
             'id' => $idprocesso,
             'diffDias' => $sql[0]->diffDias,
             'cedentes' => $cendente,
             'idTipo' => $sql[0]->idTipo,
             'idSubtipoAgenda' =>  $sql[0]->idSubtipoAgenda,
             'score' => $sql[0]->score,
         ]);
    }

    public function recuperaProcessoById($idprocesso){
        $sql = DB::table('processos')->where('id', $idprocesso)->get();

        if(count($sql) < 1){
            return response()->json([
                'status' => 'erro'
            ]);
        }

        $data_base = explode('-', $sql[0]->data_base);
        if(isset($data_base[0], $data_base[1], $data_base[2])){
            $data_base = $data_base[2].'/'.$data_base[1].'/'.$data_base[0];
        }else{
            $data_base = '';
        }

        $correcao_ate = explode('-', $sql[0]->correcao_ate);
        if(isset($correcao_ate[0], $correcao_ate[1], $correcao_ate[2])){
            $correcao_ate = $correcao_ate[2].'/'.$correcao_ate[1].'/'.$correcao_ate[0];
        }else{
            $correcao_ate = '';
        }

        $dataVencimento = explode('-', $sql[0]->dataVencimento);

        if(isset($dataVencimento[0], $dataVencimento[1], $dataVencimento[2])){
            $dataVencimento = $dataVencimento[2].'/'.$dataVencimento[1].'/'.$dataVencimento[0];
        }else{
            $dataVencimento = '';
        }

        $dataEmissaoPrecatorios = explode('-', $sql[0]->dataEmissaoPrecatorios);
        if(isset($dataEmissaoPrecatorios[0], $dataEmissaoPrecatorios[1], $dataEmissaoPrecatorios[2])){
            $dataEmissaoPrecatorios = $dataEmissaoPrecatorios[2].'/'.$dataEmissaoPrecatorios[1].'/'.$dataEmissaoPrecatorios[0];
        }else{
            $dataEmissaoPrecatorios = '';
        }

        if($sql[0]->dias_juros == ''){
            $dias_juros = 0;
        }else{
            $dias_juros = $sql[0]->dias_juros;
        }

        $chat = Chat::leftJoin('users', 'users.id','=','chat.user_id')->where('idprocesso', $idprocesso)
            ->select("chat.*", 'users.name',DB::raw("date_format(chat.created_at, '%d/%m/%Y as %H:%i') as dataEnvio"))->orderBy('created_at','desc')->get();

        $arrayChat = [];
        if(count($chat) > 0){
            foreach($chat as $dados){
                $arrayChat[] = [
                    'id' => $dados->id,
                    'name' => $dados->name,
                    'mensagem' => $dados->mensagem,
                    'dataEnvio' => $dados->dataEnvio
                ];
            }
        }


         return response()->json([
             'status' => 'ok',
             'arrayChat' => $arrayChat,
             'user_id' => $sql[0]->user_id,
             'cabeca_de_acao' => $sql[0]->cabeca_de_acao,
             'cdProcesso' => $sql[0]->cdProcesso,
             'data_id' => $sql[0]->data_id,
             'ordem_cronologica' => $sql[0]->ordem_cronologica,
             'data_nascimento' => $sql[0]->data_nascimento,
             'exp' => $sql[0]->exp,
             'processo_de_origem' => $sql[0]->processo_de_origem,
             'vara' => $sql[0]->vara,
             'reqte' => $sql[0]->reqte,
             'advogado' => $sql[0]->advogado,
             'entidade_devedora' => $sql[0]->entidade_devedora,
             'cpf' => $sql[0]->cpf,
             'data' => $sql[0]->data,
             'total_condenacao' => $sql[0]->total_condenacao,
             'requisitado' => $sql[0]->requisitado,
             'principal_bruto' => $sql[0]->principal_bruto,
             'principal_bruto_format' => number_format($sql[0]->principal_bruto,2,',','.'),
             'juros_moratorio' => $sql[0]->juros_moratorio,
             'juros_moratorio_format' => number_format($sql[0]->juros_moratorio,2,',','.'),
             'natureza' => $sql[0]->natureza,
             'data_base' => $data_base,
             'correcao_ate' => $correcao_ate,
             'inicio_data_base_taxa' => $sql[0]->inicio_data_base_taxa,
             'inicio_correcao_taxa' => $sql[0]->inicio_correcao_taxa,
             'dias_juros' => $dias_juros,
             'percentual_ass_med' => $sql[0]->percentual_ass_med,
             'pagamento_parcias' => $sql[0]->pagamento_parcias,
             'cessao_sem_honorario' => $sql[0]->cessao_sem_honorario,
             'pagamento_cessao' => $sql[0]->pagamento_cessao,
             'previdencia_ativo' => $sql[0]->previdencia_ativo,
             'spprev_format' => 'R$ '.number_format($sql[0]->spprev,2,',','.'),
             'honorarios_format' => 'R$ '.number_format($sql[0]->honorarios,2,',','.'),
             'saldo_atualizado_format' => 'R$ '.number_format($sql[0]->saldo_atualizado,2,',','.'),
             'valor_csh_format' => 'R$ '.number_format($sql[0]->valor_csh,2,',','.'),
             'valor_pagamento_cessao_format' => 'R$ '.number_format($sql[0]->valor_pagamento_cessao,2,',','.'),
             'valor_pagamento_cessao_sh_format' => 'R$ '.number_format($sql[0]->valor_csh,2,',','.'),
             'valor_pagamento_parciais' => 'R$ '.number_format($sql[0]->valor_pagamento_parciais,2,',','.'),
             'principal_bruto_calculo' => 'R$ '.number_format($sql[0]->principal_bruto_calculo,2,',','.'),
             'juros_moratorios_calculo' => 'R$ '.number_format($sql[0]->juros_moratorios_calculo,2,',','.'),
             'total_bruto' => 'R$ '.number_format($sql[0]->total_bruto,2,',','.'),
             'juros_sobre_principal' => 'R$ '.number_format($sql[0]->juros_sobre_principal,2,',','.'),
             'desconto17' => $sql[0]->desconto17,
             'diffDias' => $sql[0]->diffDias,
             'dataVencimento' => $dataVencimento,
             'dataEmissaoPrecatorios' => $dataEmissaoPrecatorios
         ]);
    }

    public function postAtualizarCalculos(Request $request){
        $input = $request->all();

         if(!isset($input['mcPercentualAM'])){
            $input['mcPercentualAM'] = 0;
         }

         $mcIndiceDataBase = explode('/', $input['mcIndiceDataBase']);
         $mcIndiceCorrecaoAte = explode('/', $input['mcIndiceCorrecaoAte']);

         if(isset($mcIndiceDataBase[2], $mcIndiceDataBase[1], $mcIndiceDataBase[0])){
             //$mcIndiceDataBase = $mcIndiceDataBase[2].'-'.$mcIndiceDataBase[1].'-'.$mcIndiceDataBase[0];
         }else{
             return response()->json([
                 'status' => 'erro1'
             ]);
         }

         if(isset($mcIndiceCorrecaoAte[2], $mcIndiceCorrecaoAte[1], $mcIndiceCorrecaoAte[0])){
             //$mcIndiceCorrecaoAte = $mcIndiceCorrecaoAte[2].'-'.$mcIndiceCorrecaoAte[1].'-'.$mcIndiceCorrecaoAte[0];
         }else{
             return response()->json([
                 'status' => 'erro2'
             ]);
         }

         $diffDias = '800';
        //  try{
        //      $mcDataEmissaoPrecatorio = explode('/', $input['mcDataEmissaoPrecatorio']);
        //      $mcDataVencimento = explode('/', $input['mcDataVencimento']);
        //      if(!is_null($input['mcDataEmissaoPrecatorio'])){
        //         $mcDataEmissaoPrecatorio1 = new \DateTime($mcDataEmissaoPrecatorio[2].'-'.$mcDataEmissaoPrecatorio[1].'-'.$mcDataEmissaoPrecatorio[0]);
        //         $mcDataEmissaoPrecatorio = $mcDataEmissaoPrecatorio[2].'-'.$mcDataEmissaoPrecatorio[1].'-'.$mcDataEmissaoPrecatorio[0];

        //      }else{
        //         $mcDataEmissaoPrecatorio = '';
        //      }
        //      if(!is_null($input['mcDataEmissaoPrecatorio'])){
        //         $mcDataVencimento1 = new \DateTime($mcDataVencimento[2].'-'.$mcDataVencimento[1].'-'.$mcDataVencimento[0]);
        //         $diffDias = $mcDataVencimento1->diff($mcDataEmissaoPrecatorio1);
        //         $diffDias = $diffDias->format('%R%a');
        //         $mcDataVencimento = $mcDataVencimento[2].'-'.$mcDataVencimento[1].'-'.$mcDataVencimento[0];

        //      }else{
        //         $mcDataVencimento = '';
        //         $diffDias = '';
        //      }
        //  }catch(Exception $e){
            //  $diffDias = '';
             $mcDataVencimento = '';
             $mcDataEmissaoPrecatorio = '';
        //  }

         $data_inicio = new \DateTime($mcIndiceDataBase[2].'-'.$mcIndiceDataBase[1].'-'.$mcIndiceDataBase[0]);
         $data_fim = new \DateTime($mcIndiceCorrecaoAte[2].'-'.$mcIndiceCorrecaoAte[1].'-'.$mcIndiceCorrecaoAte[0]);

         // Resgata diferença entre as datas
         $dateInterval = $data_inicio->diff($data_fim);
         $diferencaDias = $dateInterval->days;
         $diferencaAnos = $dateInterval->y;

         $diferencaDias = $this->diff360($mcIndiceDataBase[2].'-'.$mcIndiceDataBase[1].'-'.$mcIndiceDataBase[0],
         $mcIndiceCorrecaoAte[2].'-'.$mcIndiceCorrecaoAte[1].'-'.$mcIndiceCorrecaoAte[0] );

         $mesIndiceDataBase = '';
         $anoIndiceDataBase = '';

         $mesIndiceCorrecaoAte = '';
         $anoIndiceCorrecaoAte = '';

         $dataBancoInicio = $mcIndiceDataBase[2].'-'.$mcIndiceDataBase[1].'-'.$mcIndiceDataBase[0];
         $dataBancoFinal = $mcIndiceCorrecaoAte[2].'-'.$mcIndiceCorrecaoAte[1].'-'.$mcIndiceCorrecaoAte[0];

         switch($mcIndiceDataBase[1]){
            case '01':
                $mesIndiceDataBase = 'Jan';
                break;
            case '02':
                $mesIndiceDataBase = 'Fev';
                break;
            case '03':
                $mesIndiceDataBase = 'Mar';
                break;
            case '04':
                $mesIndiceDataBase = 'Abr';
                break;
            case '05':
                $mesIndiceDataBase = 'Mai';
                break;
            case '06':
                $mesIndiceDataBase = 'Jun';
                break;
            case '07':
                $mesIndiceDataBase = 'Jul';
                break;
            case '08':
                $mesIndiceDataBase = 'Ago';
                break;
            case '09':
                $mesIndiceDataBase = 'Set';
                break;
            case '10':
                $mesIndiceDataBase = 'Out';
                break;
            case '11':
                $mesIndiceDataBase = 'Nov';
                break;
            case '12':
                $mesIndiceDataBase = 'Dez';
                break;
         }

         switch($mcIndiceCorrecaoAte[1]){
            case '01':
                $mesIndiceCorrecaoAte = 'Jan';
                break;
            case '02':
                $mesIndiceCorrecaoAte = 'Fev';
                break;
            case '03':
                $mesIndiceCorrecaoAte = 'Mar';
                break;
            case '04':
                $mesIndiceCorrecaoAte = 'Abr';
                break;
            case '05':
                $mesIndiceCorrecaoAte = 'Mai';
                break;
            case '06':
                $mesIndiceCorrecaoAte = 'Jun';
                break;
            case '07':
                $mesIndiceCorrecaoAte = 'Jul';
                break;
            case '08':
                $mesIndiceCorrecaoAte = 'Ago';
                break;
            case '09':
                $mesIndiceCorrecaoAte = 'Set';
                break;
            case '10':
                $mesIndiceCorrecaoAte = 'Out';
                break;
            case '11':
                $mesIndiceCorrecaoAte = 'Nov';
                break;
            case '12':
                $mesIndiceCorrecaoAte = 'Dez';
                break;
         }

         $anoIndiceDataBase = $mcIndiceDataBase[2][2].$mcIndiceDataBase[2][3];
         $anoIndiceCorrecaoAte = $mcIndiceCorrecaoAte[2][2].$mcIndiceCorrecaoAte[2][3];

         $sqlTaxaAte = Taxa::where('data', 'like', $mesIndiceCorrecaoAte.'/'.$anoIndiceCorrecaoAte)->get();
         $sqlTaxaBase = Taxa::where('data', 'like', $mesIndiceDataBase.'/'.$anoIndiceDataBase)->get();

         if(count($sqlTaxaAte) > 0){
             $taxaAte = $sqlTaxaAte[0]->IPCA;
         }else{
             return response()->json([
                 'status' => 'erro3'
             ]);
         }

         if(count($sqlTaxaBase) > 0){
             $taxaBase = $sqlTaxaBase[0]->IPCA;
         }else{
             return response()->json([
                 'status' => 'erro4'
             ]);
         }



         //$taxaBase = 13.8945240;

         if($input['desconto17'] == 1){
             //$diferencaDias = 1;
             $diferencaDias = $diferencaDias - 800;
         }

         if($diferencaDias < 1){
             $diferencaDias = 1;
         }

         $diferencaDias = 800;


         if($diffDias < 0){
             $diffDias = $diffDias * -1;
         }



         if($diffDias != ''){
             $diferencaDias = $diferencaDias - $diffDias;
         }

         /* ALTERACAO RECENTE -> Forcando a diferenca de dias, para ficar sempre em 800 */
         /*$diffDias = 800;
         $diferencaDias = 800;*/


         $mcValorPrincipal = $input['mcValorPrincipal'];
         $mcValorPrincipal = str_replace('.', '', $mcValorPrincipal);
         $mcValorPrincipal = str_replace(',', '.', $mcValorPrincipal);

         $mcValorJuros = $input['mcValorJuros'];
         $mcValorJuros = str_replace('.', '', $mcValorJuros);
         $mcValorJuros = str_replace(',', '.', $mcValorJuros);

         $result1 = $mcValorPrincipal/$taxaBase*$taxaAte;
         $result2 = $mcValorJuros/$taxaBase*$taxaAte;

         $jurosSobrePrincipal = $result1/36000*6*$diferencaDias;

         $mcPercentualAm = str_replace('%','', $input['mcPercentualAM']);
         if($mcPercentualAm == ''){
             $mcPercentualAm = 0;
         }

         $mcCessaoSemHonorarios = str_replace('%','', $input['mcCessaoSemHonorarios']);
         if($mcCessaoSemHonorarios == ''){
             $mcCessaoSemHonorarios = 1;
         }

         $mcPagamentoCessao = str_replace('%','', $input['mcPagamentoCessao']);
         if($mcPagamentoCessao == ''){
             $mcPagamentoCessao = 1;
         }

         $mcCessaoSemHonorarios = str_replace(',', '.', $mcCessaoSemHonorarios);
         $mcPagamentoCessao = str_replace(',', '.', $mcPagamentoCessao);

         if($input['mcPagamentosParciais'] == ''){
             $input['mcPagamentosParciais'] = 0;
         }

         $mcPagamentosParciais = $input['mcPagamentosParciais'];
         $mcPagamentosParciais = str_replace('.', '', $mcPagamentosParciais);
         $mcPagamentosParciais = str_replace(',', '.', $mcPagamentosParciais);

         $subsomaPercentualAm = $mcPercentualAm + 5;

         if($mcPercentualAm < 5){
             $subsomaPercentualAm = '10'.$subsomaPercentualAm;
         }else{
            $subsomaPercentualAm = '1'.$subsomaPercentualAm;
         }

         if($mcPercentualAm > 0){
             //$a = 0.00017351 * $diferencaDias;
             $a = 0.00017351 * $diferencaDias;
         }else{
             $a = 0.000170301 * $diferencaDias;
         }

         $a = 0;

         $soma1 = ($result1 + $result2 + $jurosSobrePrincipal);

         //$saldoAtualizado = ( $soma1 / ($subsomaPercentualAm/100) - $mcPagamentosParciais ) + $a;

         $saldoAtualizado = (($result1 + $result2 + $jurosSobrePrincipal) + $mcPagamentosParciais ) + $a;
         $valorCessaoSemHonorarios = round($saldoAtualizado,2) * (round($mcCessaoSemHonorarios)/100);
         $valorPagamentoCesso = round($valorCessaoSemHonorarios - ($valorCessaoSemHonorarios * 0.09)) * (round($mcPagamentoCessao)/100);
         $totalBruto = $soma1;

         if($input['mcPercentualAM'] == 13){
             $totalSpprev = $soma1 * 0.13;
         }else{
             $totalSpprev = 0;
         }

         $totalHonorarios = $saldoAtualizado * 0.3;

         if($input['desconto17'] == 1){
             $desconto17 = 0;
         }else{
             $desconto17 = 0;
         }

         /*dd($valorCessaoSemHonorarios);

         $valorCessaoSemHonorarios = ($valorCessaoSemHonorarios - ($valorCessaoSemHonorarios * 0.09) - $totalSpprev);*/

         $valorCessaoSemHonorariosCerto = ($totalBruto - $totalHonorarios - $totalSpprev);
         $valorPagamentoCesso = round($valorCessaoSemHonorariosCerto) * (round($mcPagamentoCessao)/100);


         $sql = Processos::find($input['id']);
         $sql->inicio_data_base_taxa = $taxaBase;
         $sql->inicio_correcao_taxa = $taxaAte;
         $sql->dias_juros = $diferencaDias;
         $sql->spprev = $totalSpprev;
         $sql->honorarios = $totalHonorarios;
         $sql->saldo_atualizado = $saldoAtualizado;
         $sql->valor_csh = $valorCessaoSemHonorariosCerto;
         $sql->valor_pagamento_cessao = $valorPagamentoCesso;
         $sql->percentual_ass_med = $mcPercentualAm;
         $sql->valor_pagamento_parciais = $mcPagamentosParciais;
         $sql->cessao_sem_honorario = $mcCessaoSemHonorarios;
         $sql->pagamento_cessao = $mcPagamentoCessao;
         $sql->data_base = $dataBancoInicio;
         $sql->correcao_ate = $dataBancoFinal;
         $sql->juros_sobre_principal = $jurosSobrePrincipal;
         $sql->principal_bruto = $mcValorPrincipal;
         $sql->total_bruto = $totalBruto;
         $sql->desconto17 = $desconto17;
         if($mcDataVencimento && $mcDataVencimento != '' && !is_null($mcDataVencimento)){
            $sql->dataVencimento = $mcDataVencimento;
         }
         if($mcDataEmissaoPrecatorio && $mcDataEmissaoPrecatorio != '' && !is_null($mcDataEmissaoPrecatorio)){
            $sql->dataEmissaoPrecatorios = $mcDataEmissaoPrecatorio;
         }
         if($diffDias && $diffDias != '' && !is_null($diffDias)){
            $sql->diffDias = $diffDias;
         }
         $sql->save();

         try{
            DB::table('movimentacoes')->insert([
               'idfuncionario' => auth()->user()->id,
               'idtipo' => 5,
               'created_at' => DB::raw('now()')
            ]);
         }catch(\Exception $e){

         }
         return response()->json([
             'status' => 'ok',
             'taxaAte' => $taxaAte,
             'taxaBase' => $taxaBase,
             'dias' => $diferencaDias,
             'result1' => number_format($result1,2),
             'result1Format' => 'R$ '.number_format($result1,2,',','.'),
             'result2' => number_format($result2,2),
             'result2Format' => 'R$ '.number_format($result2,2,',','.'),
             'jurosSobrePrincipal' => number_format($jurosSobrePrincipal, 2),
             'jurosSobrePrincipalFormat' => 'R$ '.number_format($jurosSobrePrincipal,2,',','.'),
             'mcPercentualAm' => $mcPercentualAm,
             'saldoAtualizado' => 'R$ '.number_format($saldoAtualizado, 2, ',','.'),
             'valorCessaoSemHonorarios' => 'R$ '.number_format($valorCessaoSemHonorariosCerto,2,',','.'),
             'valorPagamentoCesso' => 'R$ '.number_format($valorPagamentoCesso,2,',','.'),
             'totalBruto' => 'R$ '.number_format($totalBruto,2,',','.'),
             'totalSpprev' => 'R$ '.number_format($totalSpprev,2,',','.'),
             'totalHonorarios' => 'R$ '.number_format($totalHonorarios,2,',','.'),
             'desconto17' => $desconto17,
             'dataEmissaoPrecatorios' => $input['mcDataEmissaoPrecatorio'],
             'dataVencimento' => $input['mcDataVencimento'],
             'diffDias' => $diffDias
         ]);

    }

    public function postEnviarChat(Request $request){
        $input = $request->all();

        $chat = new Chat;
        $chat->idprocesso = $input['idprocesso'];
        $chat->user_id = Auth::user()->id;
        $chat->mensagem = $input['mensagem'];
        $chat->save();

        $chat = Chat::leftJoin('users', 'users.id','=','chat.user_id')->where('chat.id', $chat->id)
            ->select("chat.*", 'users.name',DB::raw("date_format(chat.created_at, '%d/%m/%Y as %H:%i') as dataEnvio"))->orderBy('created_at','desc')->get();

        $log = new Log;
        $log->id_funcionario = auth()->user()->id;
        $log->id_processo = $input['idprocesso'];
        $log->anotacao = $input['mensagem'];
        $log->save();
        return response()->json([
            'status' => 'ok',
            'response' => [
                'id' => $chat[0]->id,
                'name' => $chat[0]->name,
                'dataEnvio' => $chat[0]->dataEnvio,
                'mensagem' => $chat[0]->mensagem
            ]
        ]);
    }

    public function webhookValidaNumero(Request $request){
        $input = $request->all();

        DB::table('teste')->insert([
            'campo1' => 'webhook',
            'campo2' => 'vai receber o webhook'
        ]);

        try{
            DB::table('teste')->insert([
                'campo1' => 'webhook',
                'campo2' => $input['id']
            ]);

            DB::table('teste')->insert([
                'campo1' => 'webhook',
                'campo2' => $input
            ]);
        }catch(\Exception $e){
            DB::table('teste')->insert([
                'campo1' => 'exception',
                'campo2' => $e->getMessage()
            ]);
        }
    }

    public function testeValidaNumero(){
        $response = Curl::to('https://api2.totalvoice.com.br/valida_numero')
            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
            ->withData([
                 'numero_destino' => '24999765328'
             ])->asJson()->post();

        dd($response);
    }
    public function buscaValidaNumero(){
        $response = Curl::to('https://api2.totalvoice.com.br/valida_numero/102704636')
            ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
            ->asJson()->get();

        dd($response);
    }

    public function verificaResultadosTelefone(Request $request){
        $input = $request->all();
        $sql = Telefones::where('isConsultado', 0)->where('tentativas', '<', 4)->take(10)->get();
        if(count($sql) > 0){
            foreach($sql as $dados){
                $response = Curl::to('https://api.totalvoice.com.br/valida_numero/'.$dados->callId)
                    ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                    ->asJson()->get();
                if($response->status == '200'){
                    if($response->dados->status != 'preparando'){
                        $tentativas = $dados->tentativas;
                        $status = $response->dados->status;

                        if($tentativas >= 3){
                            $isConsultado = 1;
                            if($response->dados->valido == false){
                                $status = 'Inválido';
                            }
                        }else{
                            $isConsultado = 0;
                        }

                        if($response->dados->valido == true){
                            $isConsultado = 1;
                        }

                        Telefones::where('id', $dados->id)->update([
                            'returnStatus' => $status,
                            'isConsultado' => $isConsultado,
                            'tentativas' => DB::raw('(tentativas + 1)')
                        ]);

                        //if($response->dados->valido == true){

                        //}else{
                            /*Telefones::where('id', $dados->id)->update([
                                'returnStatus' => 'Inválido',
                                'isConsultado' => 0,
                                'tentativas' => DB::raw('(tentativas + 1)')
                            ]);*/
                        //}

                    }
                }
            }
        }
    }

    public function disparaLigacaoJive(Request $request){
        $input = $request->all();
        $telefone = $input['telefone'];
        $telefone = str_replace('(', '', $telefone);
        $telefone = str_replace(')', '', $telefone);
        $telefone = str_replace('-', '', $telefone);
        $telefone = str_replace(' ', '', $telefone);

        $sqlToken = DB::table('token')->where('iduser', Auth::user()->id)->get();

        if(count($sqlToken) > 0){
            foreach($sqlToken as $dados){
                //tem o token, então tenta pegar as linhas
                $response = Curl::to('https://api.jive.com/users/v1/lines')
                    ->withHeader('Authorization: Bearer '.$dados->access_token.'')
                    //->withContentType('application/x-www-form-urlencoded')
                    ->get();

                $response = json_decode($response);

                if(isset($response->items) && count($response->items) > 0){
                    $line_id = $response->items[0]->organization->id;

                    $response = Curl::to('https://api.jive.com/calls/v2/calls')
                        ->withHeader('Authorization: Bearer '.$dados->access_token.'')
                        ->withContentType('application/json')
                        ->withData(json_encode(array(
                            'dialString' => $telefone,
                            'from' => array('lineId' =>$line_id),
                          )))->post();

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                          CURLOPT_URL => "https://api.jive.com/calls/v2/calls",
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 30,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS => json_encode(array(
                              'dialString' => $telefone,
                              'from' => array('lineId' =>$line_id),
                            )),
                          CURLOPT_HTTPHEADER => [
                            "authorization: Bearer ".$dados->access_token."",
                            "content-type: application/json"
                          ],
                        ]);



                    $response = curl_exec($curl);
                    $res = json_decode($response);
                    curl_close($curl);


                    if(isset( $res->errorCode )){

                        if( $res->errorCode == 'AUTHN_INVALID_TOKEN' ){
                            return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&scopes=users.v1.lines.read%20calls.v2.initiate&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');
                        }

                    }else{

                    }
                }else{
                    /*return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');*/
                    return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&scopes=users.v1.lines.read%20calls.v2.initiate&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');
                }
            }
        }else{
            /*return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');*/
            return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&scopes=users.v1.lines.read%20calls.v2.initiate&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');
        }
    }

    public function disparaLigacaoJiveBKP(Request $request){
        $input = $request->all();

        $telefone = $input['telefone'];
        $telefone = str_replace('(', '', $telefone);
        $telefone = str_replace(')', '', $telefone);
        $telefone = str_replace('-', '', $telefone);
        $telefone = str_replace(' ', '', $telefone);

        /*return redirect('https://authentication.logmeininc.com/oauth/authorize?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&state='.$telefone.'');*/


        $sqlToken = DB::table('token')->where('iduser', Auth::user()->id)->get();

        if(count($sqlToken) > 0){
            foreach($sqlToken as $dados){

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.jive.com/calls/v2/calls", CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\n    \"dialString\": \" ".$telefone." \",\n    \"from\": {\n      \"lineId\": \"9442cf84-2451-492d-8e61-743b8c21d204\"\n    }\n  }",
                    CURLOPT_HTTPHEADER => array(
                        "authorization: Bearer ".$dados->access_token."",
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $res = json_decode($response);
                curl_close($curl);

                if(isset( $res->errorCode )){

                    if( $res->errorCode == 'AUTHN_INVALID_TOKEN' ){
                        //faz o refresh do token
                        $response = Curl::to('https://authentication.logmeininc.com/oauth/token')
                            ->withHeader('Authorization: Basic Y2JmYzQwMjQtNjUwOC00ZDQ0LTg2MzYtZGFlN2VmMzZiYjFkOnhOeGFqUWJZZFcwUG14KzZpcmZCWlE9PQ==')
                            ->withContentType('application/x-www-form-urlencoded')
                            ->withData([
                                'grant_type' => 'refresh_token',
                                'refresh_token' => $dados->refresh_token,
                             ])->post();


                        $res = json_decode($response);

                        if(isset($res->access_token)){
                            DB::table('token')->where('id', 1)->update([
                                'access_token' => $res->access_token
                            ]);
                        }

                        if( isset($res->error) ){

                        }

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://api.jive.com/calls/v2/calls", CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "{\n    \"dialString\": \" ".$telefone." \",\n    \"from\": {\n      \"lineId\": \"9442cf84-2451-492d-8e61-743b8c21d204\"\n    }\n  }",
                            CURLOPT_HTTPHEADER => array(
                                "authorization: Bearer ".$res->access_token."",
                                "content-type: application/json"
                            ),
                        ));

                        $response = curl_exec($curl);
                        $res = json_decode($response);
                        curl_close($curl);
                    }else{
                        return redirect('https://auth.jive.com/oauth2/v2/grant?response_type=code&client_id=cf00d760354dfe4b8eab638ba810f667&redirect_uri=https://novoapp.fairconsultoria.com.br/redirect-api&scope=Jive&state=novoapp');
                    }
                }else{
                    return response()->json([]);
                }
            }

            return view('app.close');
        }


    }
    public function postSalvarTelefone(Request $request){
        $input = $request->all();

        $telefoneF = $input['telefone'];
        $telefoneF = str_replace('(', '', $telefoneF);
        $telefoneF = str_replace(')', '', $telefoneF);
        $telefoneF = str_replace('-', '', $telefoneF);
        $telefoneF = str_replace(' ', '', $telefoneF);
        $hasTelefone = Telefones::where('telefone', $input['telefone'])->where('order_id', $input['idprocesso'])->first();
        if(is_null($hasTelefone) || empty($hasTelefone) || !$hasTelefone){
            $telefone = new Telefones;
            $telefone->telefone = $input['telefone'];
            $telefone->order_id = $input['idprocesso'];
            $telefone->numeroFormatado = $telefoneF;
            $telefone->isParente = $input['isParente'];
            $telefone->save();

            try{
                $response = Curl::to('https://api.totalvoice.com.br/valida_numero')
                    //->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                    ->withHeader('Access-Token: cf00d760354dfe4b8eab638ba810f667')
                    ->withData([
                         'numero_destino' => $telefoneF
                     ])->asJson()->post();
                     if(isset($response->dados->id)){
                         Telefones::where('id', $telefone->id)->update([
                             'callId' => $response->dados->id,
                             'isConsultado' => '0',
                             'returnStatus' => 'em consulta'
                         ]);
                     }
            }catch(\Exception $e){
                DB::table('teste')->insert([
                    'campo1' => $e->getMessage()
                ]);
            }

            DB::table('log')->insert([
                'id_funcionario' => auth()->user()->id,
                'id_processo' => $input['idprocesso'],
                'anotacao' => 'O Funcionário adicionou um novo telefone para contato' ,
                'created_at' => DB::raw('now()')
             ]);
            try{
               DB::table('movimentacoes')->insert([
                 'idfuncionario' => Auth::user()->id,
                 'idtipo' => 3,
                 'created_at' => DB::raw('now()')
               ]);
            }catch(\Exception $e){

            }

            return response()->json([
                'status' => 'ok',
                'telefone' => $telefone->telefone,
                'telefoneFormat' => $telefoneF,
                'returnStatus' => $telefone->returnStatus,
                'id' => $telefone->id
            ]);
        }else{
            return response()->json([
                'status' => 'erro',
                'mensagem' => "Telefone já se encontra cadastrado neste processo!"
            ]);
        }

    }

    public function excluirTelefone($id){
        $sql = Telefones::find($id);
        $sql->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function postSalvarEmail(Request $request){
        $input = $request->all();
        $hasEmail = Emails::where('email', $input['email'])->where('order_id', $input['idprocesso'])->first();
        if(is_null($hasEmail) || empty($hasEmail) || !$hasEmail){
        $email = new Emails;
        $email->email = $input['email'];
        $email->order_id = $input['idprocesso'];
        $email->save();

        DB::table('log')->insert([
            'id_funcionario' => auth()->user()->id,
            'id_processo' => $input['idprocesso'],
            'anotacao' => 'O Funcionário adicionou um novo e-mail para contato' ,
            'created_at' => DB::raw('now()')
         ]);
        try {
            DB::table('movimentacoes')->insert([
                'idfuncionario' => Auth::user()->id,
                'idtipo' => 4,
                'created_at' => DB::raw('now()')
              ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json([
            'status' => 'ok',
            'email' => $email->email,
            'id' => $email->id
        ]);
        }else{
            return response()->json([
                'status' => 'erro',
                'mensagem' => "E-mail já se encontra cadastrado neste processo!"
            ]);
        }
    }

    public function excluirEmail($id){
        $sql = Emails::find($id);
        $sql->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function postEnviarDocumento(Request $request){
        $input = $request->all();

        try{
             $random = Str::random(20);
             $image = $request->file('arquivo');
             $new_name = $random . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('uploads'), $new_name);

             $arquivo = new ArquivosProcesso;
             $arquivo->tituloDocumento = $input['tituloDocumento'];
             $arquivo->arquivo = $new_name;
             $arquivo->idProcesso = $input['mepIdProcesso2'];
             $arquivo->save();

             return response()->json([
                 'status' => 'ok',
                 'id' => $arquivo->id,
                 'tituloDocumento' => $input['tituloDocumento'],
                 'arquivo' => $arquivo->arquivo,
                 'dataEnvio' => date('d/m/Y').' as '.date('H:i')
             ]);
         }catch(\Exception $e){
             return response()->json([
                 'status' => 'erro',
                 'mensagem' => $e->getMessage()
             ]);
         }
    }

    public function excluirDocumento($id){
        $sql = ArquivosProcesso::find($id);
        $sql->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function downloadArquivo($id){
        $sql = ArquivosProcesso::find($id);

        return response()->download(public_path('uploads').'/'.$sql->arquivo);
    }

    public function atualizarDadosProcesso(Request $request){
        $input = $request->all();

        $rules = [
            // 'mepCabecaAcao' => 'required',
            'mepCampoNumeroProcesso' => 'required',
            'mepValorPrincipal' => 'required',
            'mepValorJuros' => 'required',
            'mepFuncionario' => 'required'
        ];

        $messages = [
            // 'mepCabecaAcao.required' => 'Digite o nome do cabeça de ação',
            'mepCampoNumeroProcesso.required' => 'Digite o número do processo',
            'mepValorPrincipal.required' => 'Digite o valor principal',
            'mepValorJuros.required' => 'Digite o valor dos juros',
            'mepFuncionario.required' => 'Digite o nome do colaborador'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return response()->json(['status' => 'erro', 'error' => $validation->errors()]);
        }

        $mepValorPrincipal = $input['mepValorPrincipal'];
        $mepValorPrincipal = str_replace('.', '', $mepValorPrincipal);
        $mepValorPrincipal = str_replace(',', '.', $mepValorPrincipal);

        $mepValorJuros = $input['mepValorJuros'];
        $mepValorJuros = str_replace('.', '', $mepValorJuros);
        $mepValorJuros = str_replace(',', '.', $mepValorJuros);

        $mepDataBase = explode('/', $input['mepDataBase']);

        if(isset($mepDataBase[2], $mepDataBase[1], $mepDataBase[0])){
            $mepDataBase = $mepDataBase[2].'-'.$mepDataBase[1].'-'.$mepDataBase[0];
        }else{
            $mepDataBase = '1900-01-01';
        }

        $order = Processos::find($input['id']);
        $order->cabeca_de_acao = $input['mepCabecaAcao'];
        $order->ordem_cronologica = $input['mepOrdemCronologica'];
        $order->data_nascimento = $input['mepDataNascimento'];
        $order->exp = $input['mepEp'];
        $order->processo_de_origem = $input['mepCampoNumeroProcesso'];
        $order->reqte = $input['mepNomeCliente'];
        $order->cpf = $input['mepCpfCliente'];
        $order->principal_bruto = $mepValorPrincipal;
        $order->juros_moratorio = $mepValorJuros;
        $order->data_base = $mepDataBase;
        $order->user_id = $input['mepFuncionario'];
        $order->save();

        $agenda= Agenda::where('processo_id', $order->id)->get();
        $agenda[0]->status_id = $input['mepSituacao'];
        $agenda[0]->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function mudarBoxAgenda(Request $request){
        $input = $request->all();

        $agenda = Agenda::where('processo_id', $input['processo_id'])->get();

        if($input['novobox'] == 'box0'){ $novostatus = 1; }
        if($input['novobox'] == 'box1'){ $novostatus = 2; }
        if($input['novobox'] == 'box2'){ $novostatus = 3; }
        if($input['novobox'] == 'box3'){ $novostatus = 4; }
        if($input['novobox'] == 'box4'){ $novostatus = 5; }
        if($input['novobox'] == 'box5'){ $novostatus = 6; }
        if($input['novobox'] == 'box6'){ $novostatus = 7; }
        if($input['novobox'] == 'box7'){ $novostatus = 8; }
        if($input['novobox'] == 'box8'){ $novostatus = 9; }

        $idagenda = $agenda[0]->id;

        Agenda::where('processo_id', $input['processo_id'])->update([
            'status_id' => $novostatus,
        ]);
        try {
            DB::table('movimentacoes')->insert([
                'idfuncionario' => Auth::user()->id,
                'idtipo' => 1,
                'created_at' => DB::raw('now()')
              ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json([
            'status' => 'ok',
            'novostatus' => $novostatus
        ]);
    }

    public function diff360($date1, $date2) {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);
        $diff = $date1->diff($date2);
        $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;

        return $diff->y * 360 + $diff->m * 30 + $days;
    }

    public function viewAgendasIndex(){
        $sql = SubtipoAgenda::leftJoin('tipo_agenda', 'subtipo_agenda.idTipoAgenda','=','tipo_agenda.id')
            ->select('subtipo_agenda.*','tipo_agenda.tipoAgenda')->get();

        $data = [
            'sql' => $sql
        ];

        return view('app.agendas.index', $data);
    }

    public function viewCadastrarAgenda(){
        $sql = TipoAgenda::all();
        $arrayTipoAgenda = [];

        if(count($sql) > 0){ foreach($sql as $dados){ $arrayTipoAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'sql' => $sql,
            'arrayTipoAgenda' => $arrayTipoAgenda
        ];

        return view('app.agendas.cadastrar', $data);
    }

    public function postCadastrarAgenda(Request $request){
        $input = $request->all();

        $rules = [
            'titulo' => 'required',
            'idTipoAgenda' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'titulo.required' => 'Digite o título dessa agenda',
            'idTipoAgenda.required' => 'Selecione o tipo da agenda',
            'status.required' => 'Selecione o status'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $agenda = new SubtipoAgenda;
        $agenda->titulo = $input['titulo'];
        $agenda->idTipoAgenda = $input['idTipoAgenda'];
        $agenda->status = $input['status'];
        $agenda->save();

        return redirect('app/agendas/index')->with('sucesso', 'Tipo de agenda cadastrada com sucesso');
    }

    public function viewEditarAgenda($id){
        $sql = TipoAgenda::all();
        $arrayTipoAgenda = [];

        if(count($sql) > 0){ foreach($sql as $dados){ $arrayTipoAgenda[$dados->id] = $dados->tipoAgenda; } }

        $sqlAgenda = SubtipoAgenda::find($id);

        $data = [
            'sql' => $sqlAgenda,
            'arrayTipoAgenda' => $arrayTipoAgenda
        ];

        return view('app.agendas.editar', $data);
    }

    public function postEditarAgenda(Request $request, $id){
        $input = $request->all();

        $rules = [
            'titulo' => 'required',
            'idTipoAgenda' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'titulo.required' => 'Digite o título dessa agenda',
            'idTipoAgenda.required' => 'Selecione o tipo da agenda',
            'status.required' => 'Selecione o status'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $agenda = SubtipoAgenda::find($id);
        $agenda->titulo = $input['titulo'];
        $agenda->idTipoAgenda = $input['idTipoAgenda'];
        $agenda->status = $input['status'];
        $agenda->save();

        return redirect('app/agendas/index')->with('sucesso', 'Tipo de agenda editada com sucesso');
    }

    public function excluirAgenda($id){
        $sql = SubtipoAgenda::find($id);

        $sql2 = Processos::where('idAgenda', $id)->get();
        if(count($sql2) > 0){ return redirect('app/agendas/index')->with('erro', 'Não é possível excluir essa agenda antes de mover os processos'); }

        $sql->delete();

        return back()->with('sucesso', 'Tipo de agenda excluida com sucesso');
    }

    public function recuperaSubTipoAjax($id){
        $sql = subtipoagenda::where('idTipoAgenda', $id)->get();

        return response()->json([
            'status' => 'ok',
            'response' => $sql
        ]);
    }

    public function viewSmsIndex(){
        $sql = MensagemSms::all();

        $data = [
            'sql' => $sql
        ];

        return view('app.sms.index', $data);
    }
    public function viewCadastrarSms(){
        return view('app.sms.cadastrar');
    }
    public function postCadastrarSms(Request $request){
        $input = $request->all();

        $rules = ['mensagem' => 'required', 'titulo' => 'required'];

        $messages = ['mensagem.required' => 'Digite a mensagem a ser enviada nesse SMS',
        'titulo' => 'Digite o título dessa mensagem'];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $sms = new MensagemSms;
        $sms->titulo = $input['titulo'];
        $sms->mensagem = $input['mensagem'];
        $sms->status = $input['status'];
        $sms->save();

        return redirect('app/sms/index')->with('sucesso','Mensagem cadastrada com sucesso');
    }
    public function viewEditarSms($id){
        $sql = MensagemSms::find($id);

        $data = [
            'sql' => $sql
        ];

        return view('app.sms.editar', $data);
    }
    public function postEditarSms(Request $request, $id){
        $input = $request->all();

        $rules = ['mensagem' => 'required', 'titulo' => 'required'];

        $messages = ['mensagem.required' => 'Digite a mensagem a ser enviada nesse SMS',
        'titulo' => 'Digite o título dessa mensagem'];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $sms = MensagemSms::find($id);
        $sms->titulo = $input['titulo'];
        $sms->mensagem = $input['mensagem'];
        $sms->status = $input['status'];
        $sms->save();

        return redirect('app/sms/index')->with('sucesso','Mensagem editada com sucesso');
    }

    public function getTaxas(){
        return Datatables(Taxa::all())->toJson();
    }
    public function cadastroTaxas(Request $request){

            $taxas = new Taxa;
            $taxas->data = $request->dataTaxa;
            $taxas->IPCA =  $request->ipcaTaxa;
            $taxas->TR =  $request->trTaxa;
            $response = $taxas->save();


    }
    public function viewTaxas(){
        return view('app.taxas.index');
    }
    public function excluirSms($id){
        $sql = MensagemSms::find($id);
        $sql->delete();

        return back()->with('sucesso', 'Mensagem excluir com sucesso');
    }
    public function getSms($id){
        $sql = MensagemSms::find($id);

        if($sql == null){
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Mensagem não encontrada'
            ]);
        }

        if($sql->status == 0){
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Mensagem não encontrada'
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'response' => [
                'id' => $sql->id,
                'titulo' => $sql->titulo,
                'mensagem' => $sql->mensagem
            ]
        ]);
    }
    public function recuperaTelefonesAgenda($idprocesso){
        $sqlTelefones = Telefones::where('order_id', $idprocesso)->where('isParente',0)->get();
        $arrayTelefones = [];

        if(count($sqlTelefones) > 0){
            foreach($sqlTelefones as $dados){
                $arrayTelefones[] = [
                    'id' => $dados->id,
                    'telefone' => $dados->telefone,
                    'returnStatus' => $dados->returnStatus,
                    'isConsultado' => $dados->isConsultado
                ];
            }
        }



        return response()->json([
            'status' => 'ok',
            'response' => $arrayTelefones
        ]);
    }

    public function disparaSms(Request $request){


        $input = $request->all();

        $rules = [
            'mensagem' => 'required',
        ];

        $messages = [];

        $validation = Validator::make($input, $rules, $messages);
        if($validation->fails()){
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Selecione uma mensagem e ao menos 1 número'
            ]);
        }
        if(!isset($input['numeros'])){ $input['numeros'] = []; }

        $sql1 = MensagemSms::find($input['mensagem']);

        if(count($input['numeros']) > 0){
            foreach($input['numeros'] as $numero){
                $sql = DB::table('processos')->where('id', $input['idprocesso'])->get();

                $mensagem = $sql1->mensagem;

                $array_variaveis = ['[[cabeca_de_acao]]', '[[reqte]]'];
                $array_replace = [$sql[0]->cabeca_de_acao, $sql[0]->reqte];

                $mensagem = str_replace($array_variaveis, $array_replace, $mensagem);

                $disparo = new DisparoMensagem;
                $disparo->mensagem = $mensagem;
                $disparo->numero = $numero;
                $disparo->status = 0;
                $disparo->isFlashSms = $input['isFlashSms'];
                $disparo->idProcesso = $input['idprocesso'];
                $disparo->save();

                ProcessSms::dispatch($disparo);
            }
        }

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function addLembreteProcesso(Request $request){
        $input = $request->all();

        $rules = [
            'data_agendamento' => 'required',
            'comentario' => 'required'
        ];

        $messages = [
            'data_agendamento.required' => 'Digite uma data para o agendamento'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'erro' => 'true'
            ]);
        }

        $data_agendamento = '';
        $data_agendamento_format = '';
        try{
            $data_agendamento_format = $input['data_agendamento'];
            $data_agendamento = explode('/', $input['data_agendamento']);
            $data_agendamento = $data_agendamento[2].'-'.$data_agendamento[1].'-'.$data_agendamento[0];
        }catch(\Exception $e){
            $data_agendamento = date('Y-m-d');
            $data_agendamento_format = date('d/m/Y');
        }

        $notificacoes = new Notificacoes;
        $notificacoes->data_agendamento = $data_agendamento;
        $notificacoes->comentario = $input['comentario'];
        $notificacoes->idprocesso = $input['idprocesso'];
        $notificacoes->idusuario = Auth::user()->id;
        $notificacoes->foi_aberto = 0;
        $notificacoes->save();

        DB::table('log')->insert([
            'id_funcionario' => auth()->user()->id,
            'id_processo' => $input['idprocesso'],
            'anotacao' => 'O Funcionário agendou um contato desse processo para o dia '.$data_agendamento.' com o comentário: '.$input['comentario'],
            'created_at' => DB::raw('now()')
         ]);
         try {
            DB::table('movimentacoes')->insert([
                'idfuncionario' => Auth::user()->id,
                'idtipo' => 2,
                'created_at' => DB::raw('now()')
              ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json([
            'status' => 'ok',
            'id' => $notificacoes->id,
            'data_agendamento' => $data_agendamento_format,
            'comentario' => $input['comentario']
        ]);
    }

    public function excluirLembreteItem(Request $request, $id){
        $sql = Notificacoes::where('idusuario', Auth::user()->id)->where('id', $id)->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function recuperaLembretes(Request $request){
        $input = $request->all();

        date_default_timezone_set('America/Sao_Paulo');

        $a = [
            'id' => Auth::user()->id,
            'role' => Auth::user()->role_id
        ];
        $sql = Notificacoes::where('foi_aberto', 0)
            ->where(function($query) use ($a) {
                if($a['role'] != 1){
                    $query->where('idusuario', Auth::user()->id);
                }
            })
            ->where('data_agendamento', 'like', date('Y-m-d').'%')
            ->leftJoin('processos', 'processos.id','=','notificacoes.idprocesso')
            ->leftJoin('users', 'users.id','=','notificacoes.idusuario')
            ->select("notificacoes.*", 'users.name','processos.processo_de_origem', 'processos.reqte', 'processos.cabeca_de_acao', DB::raw("date_format(data_agendamento, '%d/%m/%Y') as data_agendamento_format"), DB::raw("date_format(foi_aberto_em, '%d/%m/%Y') as foi_aberto_em_format"))->get();

        $array_response = [];

        if(count($sql) > 0){
            foreach($sql as $dados){
                $array_response[] = [
                    'id' => $dados->id,
                    'data_agendamento' => $dados->data_agendamento_format,
                    'comentario' => $dados->comentario,
                    'nome' => $dados->name,
                    'processo_de_origem' => $dados->processo_de_origem,
                    'cabeca_de_acao' => $dados->cabeca_de_acao,
                    'reqte' => $dados->reqte,
                    'foi_aberto' => $dados->foi_aberto,
                    'foi_aberto_em' => $dados->foi_aberto_em_format
                ];
            }
        }

        return response()->json([
            'status' => 'ok',
            'array_response' => $array_response
        ]);
    }

    public function logout(){
        Auth::logout();

        return redirect('/app/login');
    }

}
