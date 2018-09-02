<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;

class Documento extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
			'id' 		 => $this->id,
			'nome_arquivo' => $this->nome_arquivo,
            'local_armazenado'  => $this->local_armazenado,
            'usuario' => $this->user,
            // 'empresa' => $this->empresa,
			'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
		];
    }
}
