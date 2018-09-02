<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'user_name'  => $this->user_name,
			'master' 	 => $this->master,
			'status' 	 => $this->status,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}

	public function with ($request) {
		return [
			'version' 	 => '0.8.25',
			'author'	 => 'Felipe Lima',
			'author_url' => url('http://felipedelima.com')
		];
	}
}
