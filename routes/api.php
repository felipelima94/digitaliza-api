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

Route::group(['middleware' => 'cors'], function() {
    
    Route::post('login', 'API\PassportController@login');
    Route::post('register', 'API\PassportController@register');
    
    
    Route::post('new/Empresa', 'EmpresaUsuariosController@register');
    
    // rotas autenticadas   
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/get-details', 'API\PassportController@getDetails');
        Route::middleware('auth:api')->get('empresas', "EmpresaController@index");
        // Route::get('/empresas', "EmpresaController@index");
    });
    
    // list all users
    Route::get('/users', "UserController@index");

    // list all empresa_usuarios
    Route::get('/empresa-usuario', 'EmpresaUsuariosController@index');
    
    
});
// Route::get('/empresas', array('middleware' => 'cors', 'uses' => "EmpresaController@index"));

//////////// U S E R S ///////////////////////////////

// list all users
// Route::get('/users', "UserController@index");
// Route::get('/users', array('middleware' => 'cors', 'uses' => 'UserController@index'));

// get a specific user
// Route::get('/user/{id}', "UserController@show");
Route::get('/user/{id}', array('middleware' => 'cors', 'uses' => 'UserController@show'));

// create new user
// Route::post('/user', "UserController@store");
Route::post('/user', array('middleware' => 'cors', 'uses' => 'UserController@store'));

// update user existent
// Route::put('/user/{id}', "UserController@update");
Route::put('/user/{id}', array('middleware' => 'cors', 'uses' => 'UserController@update'));

// delete user
// Route::delete('/user/{id}/', "UserController@destroy");
Route::delete('/user/{id}', array('middleware' => 'cors', 'uses' => 'UserController@destroy'));

//////////// C O M P A N Y /////////////////////////////

// list all company
// Route::get('/empresas', "EmpresaController@index");

// get a specific company
// Route::get('/empresa/{empresa_id}', "EmpresaController@show");
Route::get('/empresa/{empresa_id}', array('middleware' => 'cors', 'uses' => 'EmpresaController@show'));

// create new company
// Route::post('/empresa', "EmpresaController@store");
Route::post('/empresa', array('middleware' => 'cors', 'uses' => 'EmpresaController@store'));

// Route::post('/verify/empresa', "EmpresaController@verify");
Route::post('/verify/empresa', array('middleware' => 'cors', 'uses' => 'EmpresaController@verify'));

// update company existent
// Route::put('/empresa/{empresa_id}', "EmpresaController@update");
Route::put('/empresa/{empresa_id}', array('middleware' => 'cors', 'uses' => 'EmpresaController@update'));

// delete company
// Route::delete('/empresa/{empresa_id}/', "EmpresaController@destroy");
Route::delete('/empresa/{empresa_id}', array('middleware' => 'cors', 'uses' => 'EmpresaController@destroy'));

//////////// D O C U M E N T /////////////////////////////

// list all document
// Route::get('/documentos', "DocumentoController@index");
Route::get('/documentos', array('middleware' => 'cors', 'uses' => 'DocumentoController@index'));

// get a specific document
Route::get('/documento/{id}', array('middleware' => 'cors', 'uses' => "DocumentoController@show"));

// create new document
Route::post('/documento', array('middleware' => 'cors', 'uses' => "DocumentoController@store"));

// update document existent
Route::put('/documento/{id}', array('middleware' => 'cors', 'uses' => "DocumentoController@update"));

// delete document
Route::delete('/documento/{id}/', array('middleware' => 'cors', 'uses' => "DocumentoController@destroy"));