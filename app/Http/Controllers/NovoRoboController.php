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
use App\ArquivosProcesso;
use App\TipoAgenda;
use App\SubtipoAgenda;
use App\Cedentes;
use App\MensagemSms;
use App\Notificacoes;
use App\DisparoMensagem;
use App\RoboCadernos;
use App\RoboExtracaoDetalhes;
use App\Jobs\ProcessSms;
use App\Jobs\DownloadCaderno;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ilovepdf\Ilovepdf;
use Ilovepdf\SplitTask;
use Ilovepdf\ExtractTask;

class NovoRoboController extends Controller{
    public function viewExtrairCadernos(){
        $sql = RoboCadernos::select('*', DB::raw("date_format(data, '%d/%m/%Y') as data_format"))->orderBy('data', 'asc')->get();

        $data = [
            'sql' => $sql
        ];

        return view('app.robo.extrair_cadernos', $data);
    }
    public function postExtrairCadernos(Request $request){
        $input = $request->all();

        $data = $input['data'];

        if($input['data'] == ''){
            return back()->with('erro', 'Selecione uma data para fazer o download do caderno');
        }

        try{
            $data_explode = explode('/', $input['data']);
            $data_sembarra = str_replace('/', '', $input['data']);

            $data_us = $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];
        }catch(\Exception $e){
            return back()->with('erro', 'Selecione corretamente uma data para fazer download');
        }

        $robocadernos = RoboCadernos::where('data', $data_us)->get();

        if(count($robocadernos) > 0){
            if($robocadernos[0]->is_extraindo == 1){
                return back()->with('erro', 'O caderno já esta sendo extraido');
            }

            if($robocadernos[0]->is_extraido == 1){
                return back()->with('erro', 'O caderno já foi extraido');
            }
        }

        $rc = new RoboCadernos;
        $rc->data = $data_us;
        $rc->is_extraindo = 1;
        $rc->is_extraido = 0;
        $rc->data_br = $input['data'];
        $rc->save();

        $content = file_get_contents('http://www.dje.tjsp.jus.br/cdje/downloadCaderno.do?dtDiario='.$input['data'].'&cdCaderno=11');
        file_put_contents('/home/fairconsultoria/public_html/novoapp/public/temppdf/'.$data_sembarra.'.pdf', $content);

        $rc->is_extraido = 1;
        $rc->is_extraindo = 0;
        $rc->is_split = 0;
        $rc->save();

        /*$ilovepdf = new Ilovepdf(
            'back_project_public_4920b1735dca06aaeb93d392dcb19a8c_L36pdab9c3802d513a351ea1e8a51489ac0d4',
            'back_secret_key_687193f005eee3ed1d6dc10e12161bc8_6sShF31fac5ce7b495ffd2ad86b0c08437b2e');

        $myTask = $ilovepdf->newTask('split');
        $myTask = new SplitTask(
            'back_project_public_4920b1735dca06aaeb93d392dcb19a8c_L36pdab9c3802d513a351ea1e8a51489ac0d4',
            'back_secret_key_687193f005eee3ed1d6dc10e12161bc8_6sShF31fac5ce7b495ffd2ad86b0c08437b2e');*/

        ini_set('max_execution_time', 0); // for infinite time of execution
        $ilovepdf = new Ilovepdf(
            'project_public_4920b1735dca06aaeb93d392dcb19a8c_L36pdab9c3802d513a351ea1e8a51489ac0d4',
            'secret_key_687193f005eee3ed1d6dc10e12161bc8_6sShF31fac5ce7b495ffd2ad86b0c08437b2e');

        $myTask = $ilovepdf->newTask('split');
        $myTask = new SplitTask(
            'project_public_4920b1735dca06aaeb93d392dcb19a8c_L36pdab9c3802d513a351ea1e8a51489ac0d4',
            'secret_key_687193f005eee3ed1d6dc10e12161bc8_6sShF31fac5ce7b495ffd2ad86b0c08437b2e');

        $file = $myTask->addFile('/home/fairconsultoria/public_html/novoapp/public/temppdf/'.$data_sembarra.'.pdf');
        $myTask->setRanges("1-670");
        $myTask->setPackagedFilename('split_documents');
        $myTask->setOutputFilename('split_'.$data_sembarra.'');
        $myTask->execute();
        $myTask->download('/home/fairconsultoria/public_html/novoapp/public/temppdf');

        $rc->is_split = 1;
        $rc->output_file_name = 'split_'.$data_sembarra.'';
        $rc->save();
        //ProcessSms::dispatch($disparo);

        return back()->with('sucesso', 'Disparo efetuado com sucesso');
    }

    public function viewCrawlerCaderno($id){
        $sql = RoboExtracaoDetalhes::where('campo2', $id)->get();
        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'sql' => $sql,
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.crawler_cadernos', $data);
    }

    public function iniciarLeituraCaderno($id){
        $sql = RoboCadernos::where('id', $id)->get();

        if(count($sql) < 1){
            return back()->with('erro', 'Extração não encontrada. Tente novamente');
        }

        if($sql[0]->is_extraido == 0){
            return back()->with('erro', 'Aguarde o termino da extração do carderno, antes de continuar');
        }
        if($sql[0]->is_split == 0){
            return back()->with('erro', 'Aguarde o termino da extração do carderno, antes de continuar');
        }
        if($sql[0]->is_lendo_processos == 1){
            return back()->with('erro', 'Essa extração já esta sendo lida');
        }
        if($sql[0]->is_processos_lidos == 1){
            return back()->with('erro', 'Essa extração ja foi lida. Clique para verificar os processos recuperados');
        }

        $sql[0]->is_lendo_processos = 1;
        $sql[0]->save();

        /*$ilovepdf = new Ilovepdf(
            'project_public_4920b1735dca06aaeb93d392dcb19a8c_L36pdab9c3802d513a351ea1e8a51489ac0d4',
            'secret_key_687193f005eee3ed1d6dc10e12161bc8_6sShF31fac5ce7b495ffd2ad86b0c08437b2e');
        $myTask = $ilovepdf->newTask('extract');
        $file1 = $myTask->addFile('/home/fairconsultoria/public_html/novoapp/public/temppdf/'.$sql[0]->output_file_name.'-1-670.pdf');
        $myTask->setOutputFilename('text-'.$sql[0]->output_file_name);
        $result = $myTask->execute();
        $myTask->download('/home/fairconsultoria/public_html/novoapp/public/temppdf');*/

        shell_exec('pdftotext -layout /home/fairconsultoria/public_html/novoapp/public/temppdf/'.$sql[0]->output_file_name.'-1-670.pdf /home/fairconsultoria/public_html/novoapp/public/temppdf/text-'.$sql[0]->output_file_name.'.txt');

        $arquivo = file_get_contents('/home/fairconsultoria/public_html/novoapp/public/temppdf/text-'.$sql[0]->output_file_name.'.txt');
        $key = null; $time = null; $processos = null; $validador = false;$i = 0;

        //$arquivo = mb_convert_encoding($arquivo, 'UTF-8', 'UTF-16');

        $linhas = explode("\n",  $arquivo);

        /*
            Equivalencia de campos

            processo_de_origem => campo1
            id_extracao_caderno => campo2
            ordem_cronologica =>  campo3
            vara => campo4
            reqte => campo5
            advogado = campo6
            entidade_devedora => campo7
        */
        foreach($linhas as $linha){

            $linha = trim($linha);
            $data = explode(":", $linha);

            /*if(isset($data[0])){
                $data[0] = preg_replace('/[\x00-\x1F\x7F]/', '', $data[0]);
            }
            if(isset($data[1])){
                $data[1] = preg_replace('/[\x00-\x1F\x7F]/', '', $data[1]);
            }*/

            if($data[0] == "Nº de ordem cronológica"){
                $time = trim($data[1]);
            }else{
				if($data[0] == "Processo de origem"){
						$key = $time;
						$processos = trim($data[1]);
						$findOrder = RoboExtracaoDetalhes::where('processo_de_origem',trim($data[1]))->first();
					if(!$findOrder){
                        $processo = new RoboExtracaoDetalhes;
                        $processo->campo2 = $id;
                        $processo->campo3 = $key;
                        $processo->processo_de_origem = trim($data[1]);
                        $processo->save();
                        $validador = true;
					}
                }
                if($data[0] == "Vara"){
                    $processo = RoboExtracaoDetalhes::where('processo_de_origem',$processos )->get();
                    if(isset($processo[0])){
                        $processo[0]->campo4 = trim($data[1]);
                        $processo[0]->save();
                    }
                }
                if($data[0] == "Reqte"){
                    $processo = RoboExtracaoDetalhes::where('processo_de_origem',$processos )->get();
                    if(isset($processo[0])){
                        $processo[0]->campo5 = trim($data[1]);
                        $processo[0]->save();
                    }
                }
                if($data[0] == "Advogado"){
                    $processo = RoboExtracaoDetalhes::where('processo_de_origem',$processos )->get();
                    if(isset($processo[0])){
                        $processo[0]->campo6 = trim($data[1]);
                        $processo[0]->save();

                    }
                }
                if($data[0] == "Entidade devedora"){
                    $processo = RoboExtracaoDetalhes::where('processo_de_origem',$processos )->get();
                    if(isset($processo[0])){
                        $processo[0]->campo7 = trim($data[1]);
                        $processo[0]->save();
                    }
                }
            }
            $processos =$processos;
        }

        /* Status do Python */
        /*
         0 -> Ainda não inciado
         1 -> Python Rodando ou Concluido
        */

        $sql[0]->is_lendo_processos = 0;
        $sql[0]->is_processos_lidos = 1;
        $sql[0]->save();

        return back()->with('sucesso', 'O processo foi lido com sucesso e ja pode ser enviado para a agenda');
    }

    public function excluirProcesso($id){
        $sql = RoboExtracaoDetalhes::find($id);
        $sql->delete();

        return response()->json([], 200);
        /*return response()->json([
            'status' => 'ok'
        ], 200);*/
    }

    public function getProcessosForPython(){
        $processos = RoboExtracaoDetalhes::where('passou_robo', 0)->paginate(10000);

        return response()->json($processos);
    }

    public function updateProcess(Request $request){
        $processos = RoboExtracaoDetalhes::find($request->id);
        $url =  "https://esaj.tjsp.jus.br/pastadigital/getPDF.do?".base64_decode($request->url);

        if(isset($processos)){
            $processos->cdProcesso = $request->code;
            $processos->save();

            $filename =  $processos->cdProcesso.'.pdf';
            $tempImage = base_path('public/temppdf2/'.$filename);
            $nuProcesso = explode('/', $processos->processo_de_origem);
            $arquivo = \File::copy($url, $tempImage);
            //$size = filesize(base_path('public/storage/pdf/'.$filename));

            shell_exec('pdftotext -layout /home/fairconsultoria/public_html/novoapp/public/temppdf2/'.$filename.' /home/fairconsultoria/public_html/novoapp/public/temppdf2/'.$processos->cdProcesso.'.txt');

            $fh = fopen('/home/fairconsultoria/public_html/novoapp/public/temppdf2/'.$processos->cdProcesso.'.txt','r');

            $travacondenacao = 0;
            $travarequisitado = 0;
            $travaprincipalbruto = 0;
            $travacpf = 0;

            while (!feof($fh)) {
                $line = fgets($fh);
                echo '<p>'.$line.'</p>';

                try{
                    $dado = explode(':', $line);

                    if(isset($dado[1])){
                        $coluna = trim($dado[0]);
                        $coluna = preg_replace('/[\x00-\x1F\x7F]/', '', $coluna);

                        $info = trim($dado[1]);
                        $info = preg_replace('/[\x00-\x1F\x7F]/', '', $info);

                        if(trim($coluna) == "CPF" && $travacpf == 0){
                            $travacpf = 1;

                            $info = str_replace(' ', '', $info);
                            $info = str_replace('*', '', $info);

                            $processos = RoboExtracaoDetalhes::find($request->id);
                            $processos->cpf = $info;
                            $processos->save();
                        }
                        if(trim($coluna) == "Requerente"){
                            $processos = RoboExtracaoDetalhes::find($request->id);
                            $reqteRE = trim($info);

                            $reqteRA = trim($reqteRE, "*");
                            $reqte = trim($reqteRA);
                            $processos->campo5 = $reqte;
                            $processos->save();
                        }
                        if(trim($coluna) == "Entidade devedora"){
                            $processos = RoboExtracaoDetalhes::find($request->id);
                            $processos->campo7 = trim($info);
                            $processos->save();
                        }
                        if(trim($coluna) == "Natureza"){
                            $processos = RoboExtracaoDetalhes::find($request->id);
                            $processos->natureza = trim($info);
                            $processos->save();
                        }
                        if(trim($coluna) == "Data Base" || trim($coluna) == "Data base"){
                            $processos = RoboExtracaoDetalhes::find($request->id);

                            try{
                                $data = preg_split('/\s+/',trim($info));
                                $novadata = explode('/', $data[1]);
                            }catch(\Exception $e){
                                $data = $info;
                                $novadata = $info;
                                $novadata = explode('/', $novadata);
                            }

                            $processos->data_base = date('Y-m-d',strtotime($novadata[2]."-".$novadata[1]."-".$novadata[0]));
                            /*$taxa = HomeController::extractTaxa(date('Y-m-d',strtotime($novadata[2]."-".$novadata[1]."-".$novadata[0])));
                            $processos->inicio_data_base_taxa = $taxa;*/
                            $processos->save();
                        }
                        if(trim($coluna) == "Data de nascimento"){
                            $processos = RoboExtracaoDetalhes::find($request->id);
                            $processos->data = trim($info);
                            $processos->save();
                        }
                        if(trim($coluna) == "Requisitado" && $travarequisitado == 0){
                            if(trim($info) !=  "\tNão informado pelo peticionante\t"){
                                $newvalor = null;

                                if( $info[strlen($info)-3] == ',' ){
                                    $newvalor = str_replace('.', '', $info);
                                    $newvalor = str_replace(',', '.', $newvalor);

                                    $processos = RoboExtracaoDetalhes::find($request->id);
                                    $processos->requisitado = $newvalor;
                                    $processos->save();

                                    $travarequisitado = 1;
                                }else{
                                    try{
                                        $explode = explode('.', $info);

                                        $valor = $explode[0];
                                        $centavos = $explode[1];

                                        $valor = str_replace(',','', $valor);
                                        $centavos = $centavos[1].$centavos[2];

                                        $newvalor = $valor.'.'.$centavos;

                                        $processos = RoboExtracaoDetalhes::find($request->id);
                                        $processos->requisitado = $newvalor;
                                        $processos->save();

                                        $travarequisitado = 1;
                                    }catch(\Exception $e){
                                        $newvalor = null;
                                    }
                                }
                            }else{

                            }
                        }
                        if(trim($coluna) == "Principal bruto" && $travaprincipalbruto == 0){
                            if(trim($info) != "\tNão informado pelo peticionante\t"){
                                $newvalor = 0;

                                if( $info[strlen($info)-3] == ',' ){
                                    $newvalor = str_replace('.', '', $info);
                                    $newvalor = str_replace(',', '.', $newvalor);

                                    $processos = RoboExtracaoDetalhes::find($request->id);
                                    $processos->principal_bruto = $newvalor;
                                    $processos->save();

                                    $travaprincipalbruto = 1;
                                }else{
                                    try{
                                        $explode = explode('.', $info);

                                        $valor = $explode[0];
                                        $centavos = $explode[1];

                                        $valor = str_replace(',','', $valor);
                                        $centavos = $centavos[1].$centavos[2];

                                        $newvalor = $valor.'.'.$centavos;

                                        $processos = RoboExtracaoDetalhes::find($request->id);
                                        $processos->principal_bruto = $newvalor;
                                        $processos->save();

                                        $travaprincipalbruto = 1;
                                    }catch(\Exception $e){

                                    }
                                }

                            }else{

                            }
                        }
                        if( (trim($coluna) == "Total deste requerente" || trim($coluna) == "Total da condenação") && $travacondenacao == 0){
                            if(trim($info) !=  "\tNão informado pelo peticionante\t"){
                                $newvalor = null;

                                if( $info[strlen($info)-3] == ',' ){
                                    $newvalor = str_replace('.', '', $info);
                                    $newvalor = str_replace(',', '.', $newvalor);

                                    $processos = RoboExtracaoDetalhes::find($request->id);
                                    $processos->total_condenacao = $newvalor;
                                    $processos->save();

                                    $travacondenacao = 1;
                                }else{
                                    try{
                                        $explode = explode('.', $info);

                                        $valor = $explode[0];
                                        $centavos = $explode[1];

                                        $valor = str_replace(',','', $valor);
                                        $centavos = $centavos[1].$centavos[2];

                                        $newvalor = $valor.'.'.$centavos;

                                        $processos = RoboExtracaoDetalhes::find($request->id);
                                        $processos->total_condenacao = $newvalor;
                                        $processos->save();

                                        $travacondenacao = 1;

                                    }catch(\Exception $e){
                                        $newvalor = null;
                                    }
                                }
                            }else{
                                //$processos = Order::find($request->id);
                                //$processos->total_condenacao = null;
                                //$processos->save();
                            }
                        }
                        if( substr_compare($coluna, "Juros morat", 0, 11) == 0 ){
                            if(trim($info) !=  "\tNão informado pelo peticionante\t"){
                                $newvalor = null;

                                if( $info[strlen($info)-3] == ',' ){
                                    $newvalor = str_replace('.', '', $info);
                                    $newvalor = str_replace(',', '.', $newvalor);

                                    $processos = RoboExtracaoDetalhes::find($request->id);
                                    $processos->juros_moratorio = $newvalor;
                                    $processos->save();
                                }else{
                                    try{
                                        $explode = explode('.', $info);

                                        $valor = $explode[0];
                                        $centavos = $explode[1];

                                        $valor = str_replace(',','', $valor);
                                        $centavos = $centavos[1].$centavos[2];

                                        $newvalor = $valor.'.'.$centavos;

                                        $processos = RoboExtracaoDetalhes::find($request->id);
                                        $processos->juros_moratorio = $newvalor;
                                        $processos->save();
                                    }catch(\Exception $e){
                                        $newvalor = null;
                                    }
                                }
                            }else{

                            }
                        }
                    }
                }catch(\Exception $e){

                }
            }

            fclose($fh);

            $processos = RoboExtracaoDetalhes::find($request->id);
            $processos->passou_robo = 1;
            $processos->save();

            return response()->json($processos);
        }else{
            return Response()->json(['error' => true], 500);
        }
    }

    public function iniciaCrawler($id){
        $sql = RoboCadernos::where('id', $id)->get();

        if(count($sql) < 1){
            return back()->with('erro', 'Extração não encontrada. Tente novamente');
        }

        if($sql[0]->is_extraido == 0){
            return back()->with('erro', 'Aguarde o termino da extração do carderno, antes de continuar');
        }
        if($sql[0]->is_split == 0){
            return back()->with('erro', 'Aguarde o termino da extração do carderno, antes de continuar');
        }
        if($sql[0]->is_lendo_processos == 1){
            return back()->with('erro', 'Essa extração já esta sendo lida');
        }
        if($sql[0]->is_processos_lidos == 0){
            return back()->with('erro', 'Essa extração ainda não foi lida');
        }
        if($sql[0]->status_python == 1){
            return back()->with('erro', 'O Crawler já passou por essa extração');
        }

        //$output = shell_exec('python3 robo_python.py 2>&1');

        shell_exec('python3 robo_python.py 2>/dev/null >/dev/null &');
        $sql[0]->status_python = 1;
        $sql[0]->save();

        return back()->with('sucesso', 'O crawler esta trabalhando e atualizando os dados do processo');
        //shell_exec('scl enable rh-python36 bash');
        /*$output = shell_exec('sudo python3 /home/fairconsultoria/public_html/novoapp/robo_python.py');
        echo $output;

        $sql[0]->status_python = 1;
        $sql[0]->save();

        return back()->with('sucesso', 'O crawler esta trabalhando e atualizando os dados do processo');*/

        /*dd($output)

        $sql[0]->status_python = 0;
        $sql[0]->save();

        return back()->with('sucesso', 'O crawler esta trabalhando e atualizando os dados do processo');*/
    }

    public function viewEnviarAgenda(Request $request, $id){
        $sql = RoboExtracaoDetalhes::find($id);

        if($sql == null){ return back()->with('erro', 'Item não encontrado'); }

        if($sql->passou_robo != 1){
            return back()->with('erro', 'Esse item ainda não foi atualizado pelo robô');
        }

        try{
            $processo = new Processos;
            $processo->cabeca_de_acao = $sql->campo5;
            $processo->cpProcesso = '';
            $proceoss->ordem_cronologica = '';
            $processo->exp = '';
            $processo->processo_de_origem = '';
            $processo->vara = '';
            $processo->reqte = '';
            $processo->advogado = '';
            $processo->entidade_devedora = '';
            $processo->cpf = '';
            $processo->data = '';
            $processo->total_condenacao = '';
            $processo->requisitado = '';
            $processo->principal_bruto = '';
            $processo->juros_moratorio = '';
            $processo->natureza = '';
            $processo->data_base = '';
        }catch(\Exception $e){

        }
    }

    public function viewPreviaAgenda($id){
        $sql = RoboExtracaoDetalhes::find($id);

        if($sql == null){
            return response()->json([
                'status' => 'erro'
            ]);
        }

        $sql->requisitado = number_format($sql->requisitado,2,',','.');
        $sql->principal_bruto = number_format($sql->principal_bruto,2,',','.');
        $sql->total_condenacao = number_format($sql->total_condenacao,2,',','.');
        $sql->juros_moratorio = number_format($sql->juros_moratorio,2,',','.');

        return response()->json([
            'status' => 'ok',
            'response' => $sql
        ]);
    }
    public function postPreviaAgenda(Request $request){

    }

    public function postEnviarAgenda(Request $request){
        $input = $request->all();

        $sql = RoboExtracaoDetalhes::find($input['hidden_id']);

        if($sql == null){ return back()->with('erro', 'Item não encontrado'); }

        if($sql->passou_robo != 1){
            return back()->with('erro', 'Esse item ainda não foi atualizado pelo robô');
        }
        if($sql->is_enviado_agenda != 0){
            return back()->with('erro', 'Esse item já foi enviado para a agenda');
        }

        $rules = [
            'filtroSubtipoProcesso' => 'required'
        ];

        $messages = [
            'filtroSubtipoProcesso.required' => 'Selecione um tipo de agenda'
        ];

        $validation = Validator::make($input, $rules, $messages);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $input['total_condenacao'] = str_replace('.', '', $input['total_condenacao']);
        $input['total_condenacao'] = str_replace(',', '.', $input['total_condenacao']);

        $input['requisitado'] = str_replace('.', '', $input['requisitado']);
        $input['requisitado'] = str_replace(',', '.', $input['requisitado']);

        $input['principal_bruto'] = str_replace('.', '', $input['principal_bruto']);
        $input['principal_bruto'] = str_replace(',', '.', $input['principal_bruto']);

        $input['juros_moratorio'] = str_replace('.', '', $input['juros_moratorio']);
        $input['juros_moratorio'] = str_replace(',', '.', $input['juros_moratorio']);


        //try{
            $processo = new Processos;
            $processo->cabeca_de_acao = $input['campo5'];
            $processo->cdProcesso = $input['cdProcesso'];
            $processo->ordem_cronologica = $input['campo3'];
            $processo->exp = '';
            $processo->processo_de_origem = $input['processo_de_origem'];
            $processo->vara = $input['campo4'];
            $processo->reqte = $input['campo5'];
            $processo->advogado = $input['campo6'];
            $processo->entidade_devedora = $input['campo7'];
            $processo->cpf = $input['cpf'];;
            $processo->total_condenacao = $input['total_condenacao'];
            $processo->requisitado = $input['requisitado'];
            $processo->principal_bruto = $input['principal_bruto'];
            $processo->juros_moratorio = $input['juros_moratorio'];
            $processo->natureza = $input['natureza'];
            $processo->data_base = $input['data_base'];
            $processo->idSubtipoAgenda = $input['filtroSubtipoProcesso'];
            $processo->data_id = 0;
            $processo->save();

            $sql = RoboExtracaoDetalhes::find($input['hidden_id']);
            $sql->is_enviado_agenda = 1;
            $sql->save();

            DB::table('agenda')->insert([
                'status_id' => 1,
                'processo_id' => $processo->id
            ]);

            return back()->with('sucesso', 'Processo enviado para a agenda com sucesso');

        //}catch(\Exception $e){
            dd($e->getMessage());
            return back()->with('erro', 'Ocorreu um erro ao enviar o processo para a agenda');
        //}
    }
}
