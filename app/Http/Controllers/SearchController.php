<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documento;
use App\Http\Resources\Documento as DocumentoResource;

class SearchController extends Controller
{
    public function search(Request $request) {
		$usuario_id = $request->user()->id;
		$empresa = new EmpresaUsuariosController;
        $empresa_id = $empresa->getEmpresaByUser($usuario_id)->id;
        
        $value = $request->search;

        $documentFound = exec("python3 /var/www/html/crawler/Search.1.py --search '$value' --empresaid $empresa_id");

        $docs_id = explode("/", $documentFound);
        $docs = [];
        foreach($docs_id as $doc_id) {
            if(strlen($doc_id) > 0) {
                $response = explode(",", $doc_id);
                array_push($docs, Documento::find($response[1]));
            }
        }


        return response()->json($docs, 200);
    }
}
