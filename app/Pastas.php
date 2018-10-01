<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pastas extends Model
{
    protected $fillable = [
        'nome', 'raiz', 'usuario_id', 'empresa_id',
    ];

    public function getRaiz() {
        return $this->hasOne("App\Pastas", "id", "raiz");
    }

    public function pastas() {
        return $this->hasMany("App\Pastas", "raiz", "id");
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'usuario_id');
    }

    // public function empresa() {
    //     return $this->hasOne("App\Empresa", "id", "empresa_id");
    // }
}
