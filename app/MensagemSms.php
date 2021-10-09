<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class MensagemSms extends Model{
    protected $table = 'mensagem_sms';
    protected $guarded = ['id'];
}
