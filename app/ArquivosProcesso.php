<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArquivosProcesso extends Model
{
    protected $table = 'arquivos_processo';
	protected $guarded = ['id'];
}
