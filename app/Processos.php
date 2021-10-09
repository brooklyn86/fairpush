<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Agenda;
class Processos extends Model
{
    protected $table = 'processos';
    protected $guarded = ['id'];
    public const isAvulso = 1;

    public function agenda(){
        return $this->belongsTo(Agenda::class);
    }
}
