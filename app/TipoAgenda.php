<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAgenda extends Model
{
    protected $table = 'tipo_agenda';
	protected $guarded = ['id'];
}
