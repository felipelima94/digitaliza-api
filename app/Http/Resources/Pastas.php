<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\User as UserResource;
// use App\Http\Resources\Documento as DocumentoResource;

class Pastas extends JsonResource
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
		$userAuthor['first_name'] = $this->user->first_name;
		$userAuthor['last_name'] = $this->user->last_name;
		return [
			'id' 	=> $this->id,
			'nome'  => $this->nome,
            'usuario' => $userAuthor,
			'raiz'	=> $this->getRaiz,
			// 'pastas'=> $this->pastas
			// 'created_at' => $this->created_at,
			'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
		];
	}
}
