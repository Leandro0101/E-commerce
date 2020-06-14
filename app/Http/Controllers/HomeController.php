<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Produto;
use App\Categoria;
use App\ProdutoFoto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

        $produtos = $this->produto->limit(8)->orderBy('id', 'desc')->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));
    }

    public function produto($slug)
    {   
        $produto = $this->produto->whereSlug($slug)->first();
        $comentariosRecentes = $produto->comentarios()->limit(5)->orderBy('id', 'desc')->get();
        $cliente = new Cliente();
        return view('produto', compact('produto', 'comentariosRecentes', 'cliente'));
    }

    public function exibirPorCategoria($categoria){
        $produtos = $this->produto->where('categoria', $categoria)->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));
    }

    public function buscaDeProdutos(Request $request){

        $dados = $request->all();

        $produtos = $this->produto->where('nome', 'like', '%'.$dados['pesquisa_produt'].'%')->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));

    }

}
