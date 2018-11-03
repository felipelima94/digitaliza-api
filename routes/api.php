<?php
use Illuminate\Http\Request;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function() {
    
    Route::post('login', 'API\PassportController@login');
    Route::post('register', 'API\PassportController@register');
    Route::middleware('auth:api')->post('logout', 'API\PassportController@logout');

    // /////////// users routes //////////////// //
    Route::post('verify/user', 'UserController@verify');
    
    Route::post('new/empresa', 'EmpresaUsuariosController@register');
    
    // rotas autenticadas   
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/get-details', 'API\PassportController@getDetails');

        // /////////// EmpresaUsuario /////////////////////// //

        // new user of company
        Route::post('/registerUser', "EmpresaUsuariosController@registerUser");

        // update user of company
        Route::put('/registerUser/{user_id}', "EmpresaUsuariosController@registerUser");

        Route::get('/empresa-by-user/{user_id}', "EmpresaUsuariosController@getEmpresaByUser");

        Route::get("/usuarios-by-empresa/{empresa_id}", "EmpresaUsuariosController@getUsersByEmpresa");

        // ///////// E M P R E S A ///////////// //
        Route::put('/empresa/{empresa_id}', 'EmpresaController@update');

        //////////// D O C U M E N T /////////////////////////////

        // list all document
        Route::get('/documentos', "DocumentoController@index");
        // Route::get('/documentos', array('middleware' => 'cors', 'uses' => 'DocumentoController@index'));

        // Route::get('/documentos/{empresa_id}', "DocumentoController@getDocumentoByEmpresa");
        Route::get('/documentos/{id_folder}', 'DocumentoController@getDocumentoByFolder');

        // get a specific document
        Route::get('/documento/{id}', array('middleware' => 'cors', 'uses' => "DocumentoController@show"));

        // create new document
        Route::post('/documento', array('middleware' => 'cors', 'uses' => "DocumentoController@store"));

        // update document existent
        Route::put('/documento/{id}', array('middleware' => 'cors', 'uses' => "DocumentoController@update"));

        // delete document
        Route::post('/documento/delete/{id}/', array('middleware' => 'cors', 'uses' => "DocumentoController@destroy"));
        Route::delete('/documento/{id}/', array('middleware' => 'cors', 'uses' => "DocumentoController@destroy"));

        // upload digitaliza
        Route::post('documento/digitaliza', "DocumentoController@digitaliza");

        // ///////////// S E A R C H ////////////// //
        Route::post('documento/search', "SearchController@search");
        
        // ///////////// P A S T A S ///////////// //
        // get list of folder
        Route::get('/pasta/{id}', 'PastasController@childFolders');

        // get rastro
        Route::get('/pasta/rastro/{id}', 'PastasController@getRastro');

        // get full rastro
        Route::get('/pasta/full-rastro/{id}', 'PastasController@getFullRastro');

        // criar pasta
        Route::post('/pasta', 'PastasController@store');

        // update folder
        Route::put('/pasta/{id}', 'PastasController@update');

        // delete folder
        Route::post('/pasta/delete/{id}', 'PastasController@destroy');
        Route::delete('/pasta/{id}', array('middleware' => 'cors', 'uses' => 'PastasController@destroy'));

    });
    
    // list all users
    // Route::get('/users', "UserController@index");

    // list all empresa_usuarios
    // Route::get('/empresa-usuario', 'EmpresaUsuariosController@index');
    
    
});
// Route::get('/empresas', array('middleware' => 'cors', 'uses' => "EmpresaController@index"));

//////////// U S E R S ///////////////////////////////

// list all users
// Route::get('/users', "UserController@index");
// Route::get('/users', array('middleware' => 'cors', 'uses' => 'UserController@index'));

// get a specific user
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

