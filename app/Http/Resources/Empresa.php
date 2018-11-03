<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Empresa extends JsonResource
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
			'empresa_id' => $this->id,
			'razao_social' => $this->razao_social,
			'nome_fantasia'  => $this->nome_fantasia,
			'cnpj'  => $this->cnpj,
			'inscricao_estadual' 	 => $this->inscricao_estadual,
			'email' 	 => $this->email,
			'telefone1' 	 => $this->telefone1,
			'telefone2' 	 => $this->telefone2,
			'endereco' 	 => $this->endereco,
			'numero' => $this->numero,
			'cidade' 	 => $this->cidade,
			'uf' 	 => $this->uf,
            'cep' 	 => $this->cep,
			'status' 	 => $this->status,
			'validade' => $this->validade,
			'storage' => $this->storage,
			'sufix' => $this->sufix,
			// 'created_at' => $this->created_at,
			// 'updated_at' => $this->updated_at
		];
    }
}
