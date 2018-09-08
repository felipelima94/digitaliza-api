<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Empresa;
use App\User;
use App\Http\Resources\Empresa as EmpresaResource;

class EmpresaController extends Controller
{
	public $successStatus = 200;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$Empresa = Empresa::all();

		return EmpresaResource::collection($Empresa);
	}

	public function register(Request $request)
    {

		// register new business
		$post = $request->all();

		$getUserResquest = $post['usuario'];
        $validator = Validator::make($getUserResquest, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

		$getempresaResquest = $post['empresa'];
		$validator = Validator::make($getempresaResquest, [
			'razao_social' => 'required|unique:empresas',
			'nome_fantasia' => 'required|unique:empresas',
			'cnpj' => 'required|unique:empresas',
			'inscricao_estadual' => '|unique:empresas',
			'email' => 'required',
			'telefone1' => 'required',
			'cep' => 'required',
			'endereco' => 'required',
			'numero' => 'required',
			'cidade' => 'required',
			'uf' => 'required',
			'validade' => 'required'
		]);

		if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

		$newEmpresa = $getempresaResquest;
		$empresa = Empresa::create($newEmpresa);
		
		// insert new user
        $input = $getUserResquest;
        $input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['id'] = $user->id;
		$success['first_name'] =  $user->first_name;
		$success['Empresa'] = $empresa;

        return response()->json(['success'=>$success], $this->successStatus);
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
		$empresa->razao_social 	  	 = $request->input('razao_social');
		$empresa->nome_fantasia  	 = $request->input('nome_fantasia');
		$empresa->cnpj  	  		 = $request->input('cnpj');
		$empresa->inscricao_estadual = $request->input('inscricao_estadual');
		$empresa->email     	  	 = $request->input('email');
		$empresa->telefone1     	 = $request->input('telefone1');
		$empresa->telefone2     	 = $request->input('telefone2');
		$empresa->endereco     	  	 = $request->input('endereco');
		$empresa->numero     	  	 = $request->input('numero');
		$empresa->cidade     	  	 = $request->input('cidade');
		$empresa->uf     	  		 = $request->input('uf');
		$empresa->cep     	  		 = $request->input('cep');
		$empresa->status     	  	 = $request->input('status');
		$empresa->validade     	  	 = $request->input('validade');
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
	public function verify(Request $request)
	{
		// verificar Razão social
        // Nome Fantasia 
        // CNPJ
		// Inscrição Estadual
		$uso = [];
		if (!Empresa::where('razao_social', '=', $request->input('razao_social'))->get()->isEmpty()) {
			array_push($uso, "razao_social");
		}
		if(!Empresa::where('nome_fantasia', '=', $request->input('nome_fantasia'))->get()->isEmpty()) {
			array_push($uso, "nome_fantasia");
		}
		if(!Empresa::where('cnpj', '=', $request->input('cnpj'))->get()->isEmpty()) {
			array_push($uso, "cnpj");
		}
		if($request->input('inscricao_estadual') != null)
		if(!Empresa::where('inscricao_estadual', '=', $request->input('inscricao_estadual'))->get()->isEmpty()) {
			array_push($uso, "inscricao_estadual");
		}

		return $uso;
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
