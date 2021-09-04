<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunBot1 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $dados;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cmdResult1 = shell_exec('python /home/fairconsultoria/public_html/bot1.py "'.$this->dados['nomeFormatado'].'" "'. $this->dados['nascimentoFormatado'].'" "'.$this->dados['nomeMaeFormatado'].'" "'.$this->dados['cpfFormatado'].'" "'.$this->dados['RgFormatado'].'" "'.$this->dados['generoFormatado'].'" /dev/null &'); 
        // $cmdResult2 = shell_exec('python /home/fairconsultoria/public_html/bot2.py "'.$this->dados['nomeFormatado'].'" "'. $this->dados['nascimentoFormatado'].'" "'.$this->dados['nomeMaeFormatado'].'" "'.$this->dados['cpfFormatado'].'" "'.$this->dados['RgFormatado'].'" "'.$this->dados['generoFormatado'].'" /dev/null &'); 
        // $cmdResult3 = shell_exec('python /home/fairconsultoria/public_html/bot3.py "'.$this->dados['nomeFormatado'].'" "'. $this->dados['nascimentoFormatado'].'" "'.$this->dados['nomeMaeFormatado'].'" "'.$this->dados['cpfFormatado'].'" "'.$this->dados['RgFormatado'].'" "'.$this->dados['generoFormatado'].'" /dev/null &' ); 
        
    }
}
