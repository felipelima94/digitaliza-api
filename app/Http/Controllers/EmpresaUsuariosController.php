<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Empresa;
use App\User;
use App\EmpresaUsuarios;
use App\Http\Resources\EmpresaUsuarios as EmpresaUsuariosResource;

class EmpresaUsuariosController extends Controller
{
	public $successStatus = 200;

    public function index()
	{
		$Empresa = EmpresaUsuarios::all();

		return EmpresaUsuariosResource::collection($Empresa);
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
		
		// insert new user
        $newUser = $getUserResquest;
        $newUser['password'] = bcrypt($newUser['password']);
		$user = User::create($newUser);
		
		$newEmpresa = $getempresaResquest;
		$empresa = Empresa::create($newEmpresa);

		$newEmpresaUsuario = [
			'usuario_id' => $user->id,
			'empresa_id' => $empresa->id
		];
		$empresaUsuario = EmpresaUsuarios::create($newEmpresaUsuario);
		
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['id'] = $user->id;
		// $success['first_name'] =  $user->first_name;
		// $success['Empresa'] = $empresa;
		$success['data'] = new EmpresaUsuariosResource($empresaUsuario);

        return response()->json(['success'=>$success], $this->successStatus);
    }

}
