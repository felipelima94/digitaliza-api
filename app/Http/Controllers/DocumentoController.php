<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Documento;
use App\Http\Resources\Documento as DocumentoResource;

class DocumentoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $document = document::paginate(5);
		$documento = Documento::all();

		return DocumentoResource::collection($documento);
	}

	public function getDocumentoByEmpresa($empresa_id) {
		$documentos = Documento::where('empresa_id', '=', $empresa_id)->get();

		return DocumentoResource::collection($documentos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$documento = new Documento;
		// $empresa->id                    = $request->input('id');
		$documento->empresa_id       = $request->input('empresa_id');
		$documento->usuario_id       = $request->input('usuario_id');
		$documento->nome_arquivo	 = $request->input('nome_arquivo');
		$documento->local_armazenado = $request->input('local_armazenado');   

		if($documento->save()) {
			return new DocumentoResource($documento);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// find one empresa
		$documento = Documento::find($id);

		return new DocumentoResource($documento);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$documento->id		      	 = $request->input('id');
		$documento->empresa_id       = $request->input('empresa_id');
		$documento->usuario_id       = $request->input('usuario_id');
		$documento->nome_arquivo	 = $request->input('nome_arquivo');
		$documento->local_armazenado = $request->input('local_armazenado');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$documento = Documento::findOrFail($id);

		if($documento->delete()) {
			return new DocumentoResource($documento);
		}
	}
}
