<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $user = User::paginate(5);
		$user = User::all();

		return UserResource::collection($user);
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
		$user = new User;
		$user->first_name 	  = $request->input('first_name');
		$user->last_name  	  = $request->input('last_name');
		$user->user_name  	  = $request->input('user_name');
		$user->password   	  = bcrypt($request->input('password'));
		$user->pic     	  	  = $request->input('pic');
		$user->master     	  = $request->input('master');
		$user->status     	  = $request->input('status');
		$user->remember_token = str_random(10);

		if($user->save()) {
			return new UserResource($user);
		}
	}

	public function getUserByEmpresa($id) {
		return $id;
	}

	public function verify(Requesquest $request) {
		$uso = [];
		if (!User::where('user_name', '=', $request->input('user_name'))->get()->isEmpty()) {
			array_push($uso, "user_name");
		}
		return uso;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// find one user
		$user = User::find($id);

		return new UserResource($user);
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
		$input = Input::all();
		// atualizar os dados do usuario
		$user = User::find($id);
		$user->first_name 	  = $input['first_name'];
		$user->last_name  	  = $input['last_name'];
		$user->user_name  	  = $input['user_name'];
		$picName = str_random(40);
		
		if(Input::hasFile('pic')){
			$pic = $input['pic'];
			$pic->move("/var/www/html/digitaliza-api/public/img/profile_pic/", $picName.".".$pic->getClientOriginalExtension());
			if($user->pic != '/img/profile_pic/picProfile.png')
			unlink("/var/www/html/digitaliza-api/public".$user->pic);
			$user->pic = "/img/profile_pic/".$picName.".".$pic->getClientOriginalExtension();
		}

		if((Input::get('password') && Input::get('c_password'))
			&& (strlen($input['password']) >= 8 && strlen($input['c_password']) >= 8)
			&& ($input['password'] == $input['c_password'])) {
			$user->password = bcrypt($request->input('password'));
		}
		if($user->save()) {
			return new UserResource($user);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);

		$user->deleted = true;
		$user->status = false;
		$user->user_name = str_random(40);

		if($user->save()) {
			return new UserResource($user);
		}
	}
}
