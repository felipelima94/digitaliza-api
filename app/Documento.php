<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    //
    // public function user()
    // {
    //     return $this->hasOne('App\User', 'id', 'user_id');
    // }

    public function user() {
        return $this->hasOne('App\User', 'id', 'usuario_id');
    }

    public function empresa() {
        return $this->hasOne("App\Empresa", "id", "empresa_id");
    }

    public function pasta() {
        return $this->hasOne("App\Pastas", "id", "local_armazenado");
    }
}
