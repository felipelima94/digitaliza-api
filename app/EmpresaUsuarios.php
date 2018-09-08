<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class EmpresaUsuarios extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'empresa_id', 'usuario_id'
    ];

    protected $hidden = [
        
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'usuario_id');
    }

    public function empresa() {
        return $this->hasOne("App\Empresa", "id", "empresa_id");
    }
}
