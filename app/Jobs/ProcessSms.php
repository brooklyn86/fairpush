<?php

namespace App\Jobs;

use App\DisparoMensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ixudra\Curl\Facades\Curl;

class ProcessSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     private $sms;

    public function __construct(DisparoMensagem $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
try{
        $numero = $this->sms->numero;
        $numero = str_replace('(', '', $numero); $numero = str_replace(')', '', $numero); $numero = str_replace('-', '', $numero); $numero = str_replace(' ', '', $numero);
        $numero = '55'.$numero;

        if( $this->sms->isFlashSms == 1 ){
            $codificacao = 15;
        }else{
            $codificacao = 0;
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "8433",
            CURLOPT_URL => "https://apihttp.disparopro.com.br:8433/mt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(array(
                'numero' => $numero,
                'servico' => 'short',
                'mensagem' => $this->sms->mensagem,
                'codificacao' => $codificacao,
            )),
           CURLOPT_HTTPHEADER => [
               "authorization: Bearer 2aeb694507e66827a9017a498e332ee9958e44cd",
               "content-type: application/json"
           ],
       ]);
           $response = curl_exec($curl);
           $err = curl_error($curl);

           curl_close($curl);
           $res = json_decode($response, true);
           //\Log::info($res);
           if($res['status'] == 200){
               DisparoMensagem::where('id', $this->sms->id)->update([
                   'status' => 1
               ]);
           }else{
               DisparoMensagem::where('id', $this->sms->id)->update([
                   'status' => 2
               ]);
           }
       }catch(\Exception $e){
           DisparoMensagem::where('id', $this->sms->id)->update([
               'status' => 3,
               'log' => $e->getMessage()
           ]);
       }
    }
}
