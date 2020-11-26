<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxa extends Model
{
    protected $table = 'taxas';
	protected $guarded = ['id'];
}
