<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Empresa;
use App\Http\Resources\Empresa as EmpresaResource;

class EmpresaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $user = User::paginate(5);
		$Empresa = Empresa::all();

		return EmpresaResource::collection($Empresa);
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
		$empresa = new Empresa;
		$empresa->razao_social 	  = $request->input('razao_social');
		$empresa->nome_fantasia  	  = $request->input('nome_fantasia');
		$empresa->cnpj  	  = $request->input('cnpj');
		$empresa->inscricao_estadual   	  = $request->input('inscricao_estadual');
		$empresa->email     	  = $request->input('email');
		$empresa->telefone1     	  = $request->input('telefone1');
		$empresa->telefone2     	  = $request->input('telefone2');
		$empresa->endereco     	  = $request->input('endereco');
		$empresa->numero     	  = $request->input('numero');
		$empresa->cidade     	  = $request->input('cidade');
		$empresa->uf     	  = $request->input('uf');
		$empresa->cep     	  = $request->input('cep');
		$empresa->status     	  = $request->input('status');
		$empresa->validade     	  = $request->input('validade');
		// $empresa->created_at     	  = $request->input('created_at');
		// $empresa->update_at     	  = $request->input('update_at');        


		if($empresa->save()) {
			return new EmpresaResource($empresa);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($empresa_id)
	{
		// find one empresa
		$empresa = Empresa::find($empresa_id);

		return new EmpresaResource($empresa);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($empresa_id)
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
	public function update(Request $request, $empresa_id)
	{
		// atualizar os dados da empresa
		$empresa = Empresa::find($empresa_id);
		$empresa->razao_social       = $request->input('razao_social');
		$empresa->nome_fantasia  	 = $request->input('nome_fantasia');
		$empresa->cnpj  	         = $request->input('cnpj');
		$empresa->inscricao_estadual = $request->input('inscricao_estadual');
		$empresa->email              = $request->input('email');
		$empresa->telefone1	         = $request->input('telefone1');
		$empresa->telefone2	         = $request->input('telefone2');
		$empresa->endereco	         = $request->input('endereco');
		$empresa->numero     	 	 = $request->input('numero');
		$empresa->cidade	         = $request->input('cidade');
		$empresa->uf    	         = $request->input('uf');
		$empresa->cep    	         = $request->input('cep');
		$empresa->status    	     = $request->input('status');
		$empresa->validade           = $request->input('validade');

		if($empresa->save()) {
			return new EmpresaResource($empresa);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($empresa_id)
	{
		$empresa = Empresa::findOrFail($empresa_id);

		if($empresa->delete()) {
			return new EmpresaResource($empresa);
		}
	}
}
