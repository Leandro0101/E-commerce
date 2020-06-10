<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Produto;
use App\Comentario;
use Illuminate\Http\Request;

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
        
        $this->comentario->texto = $dados['comentario'];
        $this->comentario->produto = $produto->id;
        $this->comentario->cliente = $cliente->id;
        $this->comentario->save();
    }
}
