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
use App\Date;
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
        $sql = RoboCadernos::select('*', DB::raw("date_format(data, '%d/%m/%Y') as data_format"))->orderBy('data', 'asc')->where('isExpedido','!=',1)->paginate(10);

        return view('app.robo.extrair_cadernos', compact('sql'));
    }
    public function viewExtrairCadernosExpedir(){
        $sql = RoboCadernos::select('*', DB::raw("date_format(data, '%d/%m/%Y') as data_format"))->where('isExpedido',1)->orderBy('data', 'asc')->paginate(10);

        $data = [
            'sql' => $sql
        ];

        return view('app.robo.extrair_caderno_antes', $data);
    }
    public function viewExtrairAntigoCadernos(){
        $sql = Date::select('*', DB::raw("date_format(data, '%d/%m/%Y') as data_format"))->orderBy('data', 'asc')->get();

        $data = [
            'sql' => $sql
        ];

        return view('app.robo.caderno_antigo', $data);
    }
    public function getData(Request $request){

        $hasDate = RoboCadernos::where('data',$request->data)->where('isExpedido', 1)->first();
        if($hasDate)
            return Response()->json($hasDate);
        return Response()->json([]);

    }

    public function createData(Request $request){
        $hasDate = RoboCadernos::where('data',$request->date)->first();
        if(!$hasDate){
            $date = new RoboCadernos;
            $date->data = $request->date;
            $date->data_br = $request->oldData;
            $date->isExpedido = 1;
            $date->save();
            return Response()->json($date);

        }
        return Response()->json($hasDate);

    }
    
    public function viewEnvioCertificacao(Request $request){
        
        return view('app.robo.certificacao');

    }
    public function postEnvioCertificacao(Request $request){
        
        try {
            // Define o valor default para a variável que contém o nome da imagem 
         $nameFile = null;

         // Verifica se informou o arquivo e se é válido
         if ($request->hasFile('file') && $request->file('file')->isValid()) {
             
             // Define um aleatório para o arquivo baseado no timestamps atual
             $name = uniqid(date('HisYmd'));
     
             // Recupera a extensão do arquivo
             $extension = $request->file->extension();
     
             // Define finalmente o nome
             $nameFile = "{$name}.{$extension}";
     
             // Faz o upload:
             $upload = $request->file->storeAs('xls', $nameFile);
             // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
             // Verifica se NÃO deu certo o upload (Redireciona de volta)
             if ( !$upload )
                 return redirect()
                             ->back()
                             ->with('error', 'Falha ao fazer upload')
                             ->withInput();
             
             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
             $reader->setLoadAllSheets();
 
             $spreadsheet = $reader->load('/home/fairconsultoria/public_html/novoapp/storage/app/xls/'.$nameFile);
             $nome = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 23)->getValue();
             $nascimento = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 24)->getValue();
             $nome_mae = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 25)->getValue();
             $cpf = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1, 28)->getValue();
             $explodeNome = explode(':', $nome);
             $explodeNascimento = explode(':', $nascimento);
             $explodeNomeMae = explode(':', $nome_mae);
             $explodeCpf = explode(':', $cpf);
 
             $nomeFormatado =  trim($explodeNome[1]);
             $nascimentoFormatado = trim($explodeNascimento[1]);
             $nomeMaeFormatado = trim($explodeNomeMae[1]);
             $cpfFormatado = trim($explodeCpf[1]);

             $cmdResult = shell_exec('python /home/fairconsultoria/public_html/novoapp/bot1.py "'.$nomeFormatado.'" "'. $nascimentoFormatado.'" "'.$nomeMaeFormatado.'" '.$cpfFormatado.' /dev/null &');
             dd('python /home/fairconsultoria/public_html/novoapp/bot1.py "'.$nomeFormatado.'" "'. $nascimentoFormatado.'" "'.$nomeMaeFormatado.'" '.$cpfFormatado.' /dev/null &');
             $cmdResult = shell_exec('python /home/fairconsultoria/public_html/novoapp/bot2.py "'.$nomeFormatado.'" "'. $nascimentoFormatado.'" "'.$nomeMaeFormatado.'" '.$cpfFormatado.' /dev/null &');
             $cmdResult = shell_exec('python /home/fairconsultoria/public_html/novoapp/bot3.py "'.$nomeFormatado.'" "'. $nascimentoFormatado.'" "'.$nomeMaeFormatado.'" '.$cpfFormatado.' /dev/null &');
             dd('pause');
             
         }
         } catch (\Throwable $th) {
            dd($th);
         }
    }

    public function getCertificados(Request $request){
        $path = "/home/fairconsultoria/public_html/novoapp/public/storage/certidao/".$request->cpf;
        $diretorio = dir($path);

        $arquivos = [];
        while($arquivo = $diretorio->read()){
            if($arquivo != '.' && $arquivo != '' &&  $arquivo != '..'){
                array_push($arquivos, ['url'=> url('/storage/pdfs/'.$arquivo), 'name' => $arquivo]);
            }
        }
        $diretorio->close();

        return Response()->json($arquivos);
    }

    public function isError(Request $request){
        $hasProcesso = RoboExtracaoDetalhes::where('processo_de_origem',$request->processo)->first();
        if($hasProcesso){
            $hasProcesso->isError = 1;
            $hasProcesso->save();
            return Response()->json(['message' => 'Atualizado com sucesso', 'processo' => $hasProcesso]);

        }
        return Response()->json(['message' => 'Error ao atualizar com sucesso']);

    }
    public function createProcesso(Request $request){

        $hasProcesso = RoboExtracaoDetalhes::where('processo_de_origem',$request->processo)->first();
        if(!$hasProcesso){
            $processo = new RoboExtracaoDetalhes;
            $processo->processo_de_origem = $request->processo;
            $processo->campo2 = $request->data_id;
            $processo->save();
            return Response()->json($processo);
        }else{
            $hasProcesso->campo2 = $request->data_id;
            $hasProcesso->save();
        }
        return Response()->json($hasProcesso);

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
        $myTask->setRanges("1-875");
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
    public function viewCrawlerCadernoAntes($id){
        $sql = RoboExtracaoDetalhes::where('campo2', $id)->where('passou_robo',1)->paginate(10);
        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.antes_expedir',compact('sql'),$data);
    }
    public function viewCrawlerCadernoFederais(){
        $sql = Processos::where('isFederal',1)->where('isBot',1)->paginate(10);
        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.federais',compact('sql'),$data);
    }
    public function viewCrawlerCaderno(Request $request){


        if(isset($request->de) || isset($request->ate)){

            $sql = RoboExtracaoDetalhes::where('campo2', $request->id);
            if($request->de != '' && $request->de != 0 &&  $request->de != null){
                $sql->where('total_condenacao','>=',intval($request->de));
            }
            if($request->ate != '' && $request->ate != 0 &&  $request->ate != null){
                $sql->where('total_condenacao','<=',intval($request->ate));
            }
            
        }else{
            $sql = RoboExtracaoDetalhes::where('campo2', $request->id);
        }
        
        $total = $sql->count(); 
        $sql = $sql->paginate(10);

        $sql->appends(request()->query());
        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'sql' => $sql,
            'total' => $total,
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.crawler_cadernos', $data);
    }
    public function viewCrawlerCadernoAntigo($id){
        $sql = Processos::where('data_id', $id)->get();
        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'sql' => $sql,
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.crawler_cadernos_antigo', $data);
    }
    public function viewCadernoProcessoAvulso(){
        $sql = Processos::where('isAvulso', Processos::isAvulso)->get();

        $tiposAgenda = TipoAgenda::all();
        $arrayTiposAgenda = [];

        if(count($tiposAgenda) > 0){ foreach($tiposAgenda as $dados){ $arrayTiposAgenda[$dados->id] = $dados->tipoAgenda; } }

        $data = [
            'sql' => $sql,
            'arrayTiposAgenda' => $arrayTiposAgenda
        ];

        return view('app.robo.processo_avulso', $data);
    }

    public function upload(Request $request){
        // Define o valor default para a variável que contém o nome da imagem 
    $nameFile = null;

    // Verifica se informou o arquivo e se é válido
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        
        // Define um aleatório para o arquivo baseado no timestamps atual
        // $name = uniqid(date('HisYmd'));

        // Recupera a extensão do arquivo
        // $extension = $request->file->extension();
        $nameFile = $request->file->getClientOriginalName();

        // // Define finalmente o nome
        // $nameFile = "{$name}.{$extension}";

        // Faz o upload:
        $upload = $request->file->storeAs('/public/pdfs/',$nameFile);
        // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

        // Verifica se NÃO deu certo o upload (Redireciona de volta)
        if ( !$upload )
            return Response()->json(['error' => true, 'message' => 'Falha ao fazer upload'],500);
        return Response()->json(['error' => false, 'message' => 'Upload com sucesso']);

    }
}

public function store(Request $request)
    {
        $parser = new \Smalot\PdfParser\Parser();
        $file = base_path('/storage/app/public/pdfs/'.$request->processo.'.pdf');
        $pdf = $parser->parseFile($file);
        $processo = new Processos;
        $nome = 0;
        $cpf = 0;
        $valor_principal = 0;
        $valor_juro = 0;
        $valor_req = 0;
        $processoV = 0;
        $contratuais = 0;
        $nomeReu = 0;
        $criado = 0;
        $data_conta = 0;
        $assunto_cjf = 0;
        $processoAnterior = [];
        $linhas = explode("\n", $pdf->getText());
        $nome_reu = "";
        $segundo_cpf = "";
        $processo->processo_de_origem = $request->processo;
        $processo->isFederal = 1;
        $processo->isBot = 1;
        $processo->data_id = -1;
        $processo->save();
        $totalLinhas = count($linhas);
        foreach($linhas as $linha){
            
            if(preg_match('/Data de Nascimento/', $linha) ){
                $explode = explode(' ', $linha);
                $data = (isset($explode[3]) ? trim($explode[3])  : "");
                $data = explode('/',$data);
                $data = \Carbon\Carbon::createFromDate($data[2].'-'.$data[1].'-'.$data[0])->toDateString();
                $processo->data_nascimento = $data;
                $processo->save();
            }
            if(preg_match('/Processo Anterior nº/', $linha) ){
                array_push($processoAnterior, $linha);
            }
            $explode = explode(':', $linha);
            if($processoV == 0){
                if($explode[0] == "Processo"){
                    $processoV =1;
                    $numero = explode(" ",$explode[1]);
                    $processo->processo_de_origem = (isset($numero[2]) ? trim($numero[2]) : trim($numero[1] ) );
                    
                }
            }
            if(preg_match('/Data do Protocolo/', $linha) ){
                $data = (isset($explode[1]) ? trim($explode[1])  : "");
                $data = explode('/',$data);
                $data = \Carbon\Carbon::createFromDate($data[2].'-'.$data[1].'-'.$data[0])->toDateString();
                $processo->data_protocolo = $data;
                $processo->save();
            }
            // if($explode[0] == "Nome da Vara"){
            //     array_push($processoAnterior, $explode[1]);

            // }
            // if($explode[0] == "Data Protocolo"){
            //     array_push($processoAnterior, $explode[1]);

            // }
            if($assunto_cjf == 0){
                if($explode[0] == "Assunto CJF"){
                    $processo->assunto_cjf =  trim($explode[1]);
                    $processo->save();
                    $assunto_cjf++;
                }
            }
            if($data_conta == 0){
                if($explode[0] == "Data da Conta"){

                    $data = (isset($explode[1]) ? trim($explode[1])  : "");
                
                    $data = explode('/',$data);
                    $data = \Carbon\Carbon::createFromDate($data[2].'-'.$data[1].'-'.$data[0])->toDateString();
                    $processo->data_conta = $data;
                    $processo->save();
                    $data_conta++;
                }
            }
            if($contratuais == 0) {
                if(preg_match('/Contratuais/', $linha) ){
                    $processo->contratuais =  1;
                    $processo->save();
                    $contratuais = 1;
                }
            }

            if($nome == 0){
                if($explode[0] == "Nome"){
                    $processo->cabeca_de_acao = (isset($explode[1]) ? trim($explode[1])  : "");
                    $processo->save();
                }
            }
            if($explode[0] == "Réu\t"){
                $nome = 1;
            }
            if($cpf == 0){ 
                if(preg_match('/CPF/', $linha)){
                    $processo->cpf = (isset($explode[1]) ? trim($explode[1])  : "");
                    $processo->save();
                    $cpf=1;
                }
            }
            // if($cpf == 1){ 
            //     if(preg_match('/CPF/', $linha)){
            //         if($processo->cpf != trim($explode[1])){
            //             $campo = new CampoProcesso;
            //             $processo->processo_id = $processo->id;
            //             $processo->key = 'text';
            //             $processo->name = 'Segundo CPF';
            //             $processo->value = (isset($explode[1]) ? trim($explode[1])  : "");
            //             $processo->order = ;

            //             $processo->save();
            //             $cpf=2;
            //         }
            //     }
            // }
            if($nome > 0 && $nomeReu != 1){
                if($explode[0] == "Nome"){
                    $processo->nome_reu = (isset($explode[1]) ? trim($explode[1])  : "");
                    $processo->save();
				  $nome++;
				  $nomeReu = 1;
                }
            }
  
            if($valor_principal < 2){
                if($explode[0] == "Valor Principal"){
                    if($valor_principal == 1){
                        $p = str_replace("R$ ", "", $explode[1]);
                        $p = str_replace(".", "", $p);
                        $p = str_replace(",", ".", $p);
                        $processo->	principal_bruto = (isset($explode[1]) ? trim($p)  : "");
                        $processo->save();
                    }
                    $valor_principal++;                    
                }
            }
       
            if($valor_juro < 2){
                if($explode[0] == "Valor Juros"){
                    if($valor_juro == 1){
                        $p = str_replace("R$ ", "", $explode[1]);
                        $p = str_replace(".", "", $p);
                        $p = str_replace(",", ".", $p);
                        $processo->juros_moratorio = (isset($explode[1]) ? trim($p)  : "");
                        $processo->save();
                        
                    }
                    $valor_juro++;

                }
            }
            if($valor_req == 0){
                if($explode[0] == "Valor Total do Requerente"){
                    $p = str_replace("R$ ", "", $explode[1]);
                    $p = str_replace(".", "", $p);
                    $p = str_replace(",", ".", $p);
                    $processo->valor_reqte = (isset($explode[1]) ?  trim($p) : "");
                    $processo->save();
                    $valor_req = 1;
                }
            }
            if($explode[0] == "Número de Meses (Exerc. Anteriores)"){
                $valor_req = 1;
                $meses = explode('D', $explode[1]);
                $processo->numero_meses = (isset($meses[0]) ? trim($meses[0])  : "");
                $processo->save();
                
            }
            if($criado == 0){
                if(preg_match('/Criado em/', $linha)){
                    $nlinha = explode(' ', $linha);
                    $processo->criado = 'Criado em:' .$nlinha[5].' '.$nlinha[6];
                    $processo->save();
                    $criado++;
                }
            }
        }

        // $processo->processos_anteriores = json_encode($processoAnterior);
        $processo->nome_reu = $nome_reu;
        // $processo->segundo_cpf = $segundo_cpf;
      
        $processo->save();

        return Response()->json($processo);
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

        shell_exec('pdftotext -layout /home/fairconsultoria/public_html/novoapp/public/temppdf/'.$sql[0]->output_file_name.'-1-875.pdf /home/fairconsultoria/public_html/novoapp/public/temppdf/text-'.$sql[0]->output_file_name.'.txt');

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
    /*  Mudar Lista  (AQUI) */
    public function getProcessosForPython(){
        $processos = RoboExtracaoDetalhes::where('passou_robo', 0)->where('is_type', 0)->where('isError',1)->paginate(1000);

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
            if(isset($request->type) && $request->type = 1){
                $processos->is_type = 1;
            }
            $processos->save();

            return response()->json($processos);
        }else{
            return Response()->json(['error' => true], 500);
        }
    }

    public function iniciaCrawler($id){
        $sql = RoboCadernos::where('id', $id)->get();
        $valida = RoboCadernos::where('is_crawled', 1)->get();

        foreach($valida as $caderno){
            $caderno->is_crawled = 0;
            $caderno->save();
        }

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

        // shell_exec('python3 robo_python.py 2>/dev/null >/dev/null &');
        $sql[0]->status_python = 1;
        $sql[0]->is_crawled = 1;
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

    public function getDadosRobo(){
        $caderno = RoboCadernos::where('is_crawled', 1)->first();

        $dados = RoboExtracaoDetalhes::where('campo2',$caderno->id)->where('passou_robo',0)->get();

        return Response()->json($dados);
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
            $processo->ordem_cronologica = '';
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
    public function viewRemoveAgenda(Request $request, $id){
        $sql = Processos::find($id);

        if($sql == null){ return  response()->json([
            'status' => 'error',
            'response' => false
        ]);}
        try{
            $response = Agenda::where('processo_id', $id)->delete();
        }catch(\Exception $e){

        }

        return response()->json([
            'status' => 'ok',
            'response' => $sql
        ]);
    }
    public function viewPreviaAgendaAntes($id){
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

    public function viewPreviaAgendaFederais($id){
        $sql = Processos::find($id);

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
    public function postEnviarAgendaAntes(Request $request){
        $input = $request->all();

        $sql = RoboExtracaoDetalhes::find($input['hidden_id']);

        if($sql == null){ return back()->with('erro', 'Item não encontrado'); }

        $input['total_condenacao'] = str_replace('.', '', $input['total_condenacao']);
        $input['total_condenacao'] = str_replace(',', '.', $input['total_condenacao']);

        $input['requisitado'] = str_replace('.', '', $input['requisitado']);
        $input['requisitado'] = str_replace(',', '.', $input['requisitado']);

        $input['principal_bruto'] = str_replace('.', '', $input['principal_bruto']);
        $input['principal_bruto'] = str_replace(',', '.', $input['principal_bruto']);

        $input['juros_moratorio'] = str_replace('.', '', $input['juros_moratorio']);
        $input['juros_moratorio'] = str_replace(',', '.', $input['juros_moratorio']);

// 
        try{
            $processo = RoboExtracaoDetalhes::find($input['hidden_id']);
            $processo->campo5 = $input['campo5'];
            $processo->cdProcesso = $input['cdProcesso'];
            $processo->campo3 = $input['campo3'];
            $processo->exp = '';
            $processo->processo_de_origem = $input['processo_de_origem'];
            $processo->campo4 = $input['campo4'];
            $processo->campo5 = $input['campo5'];
            $processo->campo6 = $input['campo6'];
            $processo->campo7 = $input['campo7'];
            $processo->cpf = $input['cpf'];;
            $processo->total_condenacao = $input['total_condenacao'];
            $processo->requisitado = $input['requisitado'];
            $processo->principal_bruto = $input['principal_bruto'];
            $processo->juros_moratorio = $input['juros_moratorio'];
            $processo->natureza = $input['natureza'];
            $processo->data_base = $input['data_base'];
            $processo->save();

            return back()->with('sucesso', 'Processo enviado para a agenda com sucesso');

        }catch(\Exception $e){
            dd($e->getMessage());
            return back()->with('erro', 'Ocorreu um erro ao enviar o processo para a agenda');
        }
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


        try{
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

        }catch(\Exception $e){
            dd($e->getMessage());
            return back()->with('erro', 'Ocorreu um erro ao enviar o processo para a agenda');
        }
    }
}
