<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pastas;
use App\User;
use App\Http\Resources\Pastas as PastasResource;
use App\Http\Resources\User as UserResource;

class PastasController extends Controller
{
	//
	public function index() {
		$pastas = Pastas::all();

		return PastasResource::collection($pastas);
	}

	public function childFolders($id) {
		// $pastas = Pastas::find($id);
		if($id > 0) {
			$pastas = Pastas::where('raiz', '=', $id)->get();
		}

		return PastasResource::collection($pastas);
	}

	// ao criar uma nova empresa é criado a pasta geral.
	public function new(Request $request) {
		$pasta = new Pastas;
		$pasta->nome 	  	= "Home".$request->input('empresa_id');
		$pasta->raiz 	  	= null;
		$pasta->empresa_id 	= $request->input('empresa_id');
		$pasta->usuario_id 	= $request->input('usuario_id');
		mkdir("/var/www/html/digitaliza-api/public/documentos/".$pasta->nome);

		if($pasta->save()) {
			return new PastasResource($pasta);
		}
	}

	// criar nova pasta quando usuario solicitar
	public function store(Request $request) {
		$pasta = new Pastas;
		$pasta->nome 	  	= $request->input('nome');
		$pasta->raiz 	  	= $request->input('raiz');
		$pasta->empresa_id 	= $request->input('empresa_id');
		$pasta->usuario_id 	= $request->input('usuario_id');

		$raiz = $request->input('raiz');
		$result = [];
		do {
			$rastros = Pastas::find($raiz);
			array_push($result, $rastros);
			$raiz = $rastros->raiz;
		} while ($raiz != null);
		$result = array_reverse($result);
		$link = "";
		for($i = 0; $i < count($result); $i++) {
			$link .= $result[$i]->nome."/";
		}
		mkdir("/var/www/html/digitaliza-api/public/documentos/".$link.$pasta->nome);

		
		if($pasta->save()) {
			return new PastasResource($pasta);
		}
	}

	public function getRastro($id) {
		$rasto = [];
		$temp;
		$continue = true;

		do {
			if(!empty($temp))
				array_push($rasto, $temp);
			$temp = Pastas::find($id);
			if(!$temp->raiz > 0)
				$continue = false;

			$id = $temp->raiz;

			
		} while($continue);

		$rastoReverse = array_reverse($rasto);

		return response()->json($rastoReverse, 200);
	}

	public function getFullRastro($id) {
		$rasto = [];
		$continue = true;

		do {
			$temp = Pastas::find($id);
			if(!$temp->raiz > 0)
			$continue = false;
			
			$id = $temp->raiz;
			
			array_push($rasto, $temp);
			
		} while($continue);

		$rastoReverse = array_reverse($rasto);

		return response()->json($rastoReverse);
	}

	public function update(Request $request, $id) {
		$pasta = Pastas::find($id);
		$pasta->nome 	  	= $request->input('nome');
		$pasta->raiz 	  	= $request->input('raiz');
		$pasta->empresa_id 	= $request->input('empresa_id');
		$pasta->usuario_id 	= $request->input('usuario_id');

		if($user->save()) {
			return new PastasResource($pasta);
		}
	}
}
