<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Empresa;
use App\User;
use App\Pastas;
use App\EmpresaUsuarios;
use App\Http\Resources\EmpresaUsuarios as EmpresaUsuariosResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Empresa as EmpresaResource;
use Illuminate\Support\Facades\DB;

class EmpresaUsuariosController extends Controller
{
	public $successStatus = 200;

    public function index()
	{
		$Empresa = EmpresaUsuarios::all();

		return EmpresaUsuariosResource::collection($Empresa);
	}
	
	public function getEmpresaByUser($user_id) {
		$empresaUsuario = EmpresaUsuarios::where('usuario_id', $user_id)->get()->first();
		$empresa = Empresa::where('id', $empresaUsuario->empresa_id)->get()->first();
		return new EmpresaResource($empresa);
	}

	public function getUsersByEmpresa(Request $request, $empresa_id) {
		$empresaUsuario = EmpresaUsuarios::where('empresa_id', $empresa_id)->get();

		$users = [];
		foreach($empresaUsuario as $tUsers) {
		
			if($usuario_id = $request->user()->id != $tUsers->usuario_id) {
				$user = User::find($tUsers->usuario_id);
				array_push($users, $user);
			}
		}

		return response()->json($users, 200);
	}
	
	public function generateSufix($str) {
		$sstr = explode(' ', $str);
		$sufix = "";
		$vetNome = [];
	
		foreach($sstr as $s) {
			$tsstr = str_split($s);
			foreach($tsstr as $t) {
				array_push($vetNome, strtolower($t));
			}
			
			$sufix .= $tsstr[0];
			if(count($sstr) < 3) {
				$sufix .= $tsstr[count($tsstr)-1];
			}
		}
		$sufix = strtolower($sufix);
	
		$cont = 1;
		$finalSufix = $sufix;
	
		do {
			$continue = true;
			$query = Empresa::where('sufix', $finalSufix)->get()->first();
			if(count($query)) {

				if(count($vetNome) > $cont) {
					$finalSufix = $sufix.$vetNome[$cont];
				} else {
					$finalSufix = $sufix.$vetNome[$cont-count($vetNome)].$vetNome[($cont-count($vetNome))+1];
				}

				$cont++;
			} else {
				$continue = false;
			}
	
		} while($continue);
	
		return $finalSufix;
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
		// algoritmo de gereção de sufixo
		$newEmpresa['sufix'] = $this->generateSufix($getempresaResquest['nome_fantasia']);
		$empresa = Empresa::create($newEmpresa);

		$newEmpresaUsuario = [
			'usuario_id' => $user->id,
			'empresa_id' => $empresa->id
		];
		$empresaUsuario = EmpresaUsuarios::create($newEmpresaUsuario);

		$newFolderInit = [
			'nome' 		 => "Home".$empresa->id,
			'usuario_id' => $user->id,
			'empresa_id' => $empresa->id
		];
		mkdir("/var/www/html/digitaliza-api/public/documentos/Home".$empresa->id);

		$pasta = Pastas::create($newFolderInit);

		DB::table('empresas')->where('id', $empresa->id)->update(['storage' => $pasta->id]);
		
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['id'] = $user->id;
		// $success['first_name'] =  $user->first_name;
		// $success['Empresa'] = $empresa;
		$success['data'] = new EmpresaUsuariosResource($empresaUsuario);

        return response()->json(['success'=>$success], $this->successStatus);
	}
	
	public function registerUser(Request $request, $user_id=null) {
		if($user_id != null) {
			$user = User::find($request->input('id'));
		} else {
			$user = new User;
		}
		$user->first_name 	  = $request->input('first_name');
		$user->last_name  	  = $request->input('last_name');
		$user->user_name  	  = $request->input('user_name');
		// $user->pic     	  	  = $request->input('pic');
		$user->master     	  = $request->input('master');
		$user->status     	  = $request->input('status');
		$user->remember_token = str_random(10);
		if((strlen($request->input('password')) > 0) && ($request->input('password') == $request->input('c_password')))
			$user->password	  = bcrypt($request->input('password'));

		$empresa_id = $request->input('empresa_id');

		if($user->save()) {
			if($user_id == null) {
				$newEmpresaUsuario = [
					'usuario_id' => $user->id,
					'empresa_id' => $empresa_id
				];
				$empresaUsuario = EmpresaUsuarios::create($newEmpresaUsuario);
			}
			return new UserResource($user);
		}

	}

}
