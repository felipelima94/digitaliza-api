<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('get-details', 'API\PassportController@getDetails');
    Route::get('/empresas', "EmpresaController@index");
    
});

//////////// U S E R S ///////////////////////////////

// list all users
Route::get('/users', "UserController@index");

// get a specific user
Route::get('/user/{id}', "UserController@show");

// create new user
Route::post('/user', "UserController@store");

// update user existent
Route::put('/user/{id}', "UserController@update");

// delete user
Route::delete('/user/{id}/', "UserController@destroy");

//////////// C O M P A N Y /////////////////////////////

// list all company
// Route::get('/empresas', "EmpresaController@index");

// get a specific company
Route::get('/empresa/{empresa_id}', "EmpresaController@show");

// create new company
Route::post('/empresa', "EmpresaController@store");

Route::post('/verify/empresa', "EmpresaController@verify");

// update company existent
Route::put('/empresa/{empresa_id}', "EmpresaController@update");

// delete company
Route::delete('/empresa/{empresa_id}/', "EmpresaController@destroy");

//////////// D O C U M E N T /////////////////////////////

// list all document
Route::get('/documento', "DocumentoController@index");

// get a specific document
Route::get('/documento/{id}', "DocumentoController@show");

// create new document
Route::post('/documento', "DocumentoController@store");

// update document existent
Route::put('/documento/{id}', "DocumentoController@update");

// delete document
Route::delete('/documento/{id}/', "DocumentoController@destroy");