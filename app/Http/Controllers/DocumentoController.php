<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Documento;
use App\Http\Resources\Documento as DocumentoResource;
use App\Http\Controllers\PastasController;
use App\Http\Controllers\EmpresaUsuariosController;
use Illuminate\Support\Facades\Input;

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

	public function getDocumentoByFolder($id_folder) {
		$documentos = Documento::where('local_armazenado', '=', $id_folder)->get();

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
		$usuario_id = $request->user()->id;
		$empresa = new EmpresaUsuariosController;
		$empresa_id = $empresa->getEmpresaByUser($usuario_id)->id;
		$documento = new Documento;
		$documento->empresa_id       = $empresa_id;
		$documento->usuario_id       = $usuario_id;
		$documento->local_armazenado = Input::get('local_armazenado');
		
		$file = Input::file('file');
		
		$pastas = new PastasController();
		$rastros = $pastas->getFullRastro($documento->local_armazenado);
		
		$original = $rastros->original;
		
		$rastro = "";
		foreach($original as $r) {
			$rastro .= $r->nome.'/';
		}

		$size = $file->getSize();
		$type = $file->getClientOriginalExtension();
		
		$documento->nome_arquivo	 = $file->getClientOriginalName();
		$documento->tamanho			 = $size;
		$documento->type 			 = $type;
		
		$url = '/var/www/html/digitaliza-api/public/documentos/'.$rastro;
		$file->move($url, $file->getClientOriginalName());

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

	public function digitaliza(Request $request)
	{
		$input = Input::all();

		$usuario_id = $request->user()->id;
		$empresa = new EmpresaUsuariosController;
		$empresa_id = $empresa->getEmpresaByUser($usuario_id)->id;
		$documento = new Documento;
		$documento->empresa_id       = $empresa_id;
		$documento->usuario_id       = $usuario_id;
		$documento->local_armazenado = $input['local_armazenado'];
		$documento->nome_arquivo 	 = $input['filename'].".pdf";
		$documento->type			 = "pdf";
		
		$fileName = $input['filename'];
		$images = $input['images'];
		
		$res = [];
		$imgsLinks = "";
		foreach($images as $image) {
			$imgsLinks .= '/var/www/html/temp/'.$image->getClientOriginalName().",";
			array_push($res, '/var/www/html/temp/'.$image->getClientOriginalName());
			$image->move('/var/www/html/temp/', $image->getClientOriginalName());
		}
		
		$pastas = new PastasController();
		$rastros = $pastas->getFullRastro($documento->local_armazenado);
		
		$original = $rastros->original;
		
		$rastro = "";
		foreach($original as $r) {
			$rastro .= $r->nome.'/';
		}
		
		$storage = '/var/www/html/digitaliza-api/public/documentos/'.$rastro;
		
		$py = exec("python3 /var/www/html/crawler/tess.1.py --image '$imgsLinks' --name '$fileName' --storage '$storage'");

		$documento->tamanho = filesize($storage.$documento->nome_arquivo);
		
		foreach($res  as $files) {
			unlink($files);
		}
		if($documento->save()) {
			$pdf = new DocumentoResource($documento);
			$file = $storage.$input['filename'].'.txt';
			
			$documento = new Documento();
			$documento->empresa_id = $pdf->empresa_id;
			$documento->usuario_id = $pdf->usuario_id;
			$documento->local_armazenado = $pdf->local_armazenado;
			$documento->nome_arquivo = $input['filename'].".txt";
			$documento->type = "txt";
			$documento->tamanho = filesize($storage.$documento->nome_arquivo);
			if($documento->save()){
				$txt = new DocumentoResource($documento);
				$crawler = exec("python3 /var/www/html/crawler/Crawler.1.2.py --txtid $txt->id --pdfid $pdf->id --file '$file'");
				return response()->json(["crawler"=> $crawler, "pdf"=>$pdf, "txt"=>$txt], 200);
			} else {return response()->json("error: não foi possivel salvar o arquivo txt", 500);}

		} else { return response()->json("error: não foi possivel salvar o arquivo pdf ou realizar a digitalização", 500); }
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
		$documento->tamanho			 = $request->input('tamanho');
		$documento->type 			 = $request->input('type');
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
