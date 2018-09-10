<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pastas extends Model
{
    protected $fillable = [
        'nome', 'raiz', 'usuario_id', 'empresa_id',
    ];
}
