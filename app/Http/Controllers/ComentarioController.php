<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Produto;
use App\Comentario;
use Illuminate\Http\Request;
use App\Http\Requests\ComentarioRequest;
date_default_timezone_set('America/Sao_Paulo');
class ComentarioController extends Controller
{


    private $comentario;
    private $cliente;
    private $produto;

    public function __construct()
    {
        $this->comentario = new Comentario();
        $this->cliente = new Cliente();
        $this->produto = new Produto();
    }

    public function adicionar(Request $request, $slug){
        $dados = $request->all();
        $produto = $this->produto->whereSlug($slug)->first();
        $cliente = session()->get('cliente');

        if(strlen($dados['comentario']) < 8){
            $comentario['success'] = false;
            $comentario['message'] = "Comentário muito pequeno";

            echo json_encode($comentario);

            return;
        }else if(strlen($dados['comentario']) > 500){
            $comentario['success'] = false;
            $comentario['message'] = "Comentário muito longo";

            echo json_encode($comentario);
        }else{
            $comentario['success'] = true;
            $comentario['message'] = "Obrigado pelo feedback!";

            echo json_encode($comentario);
            $this->comentario->texto = $dados['comentario'];
            $this->comentario->produto = $produto->id;
            $this->comentario->cliente = $cliente->id;
            $this->comentario->save();
        }
        
    }
}
