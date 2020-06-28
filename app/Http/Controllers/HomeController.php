<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Produto;
use App\Favorito;
use App\Categoria;
use App\ProdutoFoto;
use Illuminate\Http\Request;
date_default_timezone_set('America/Sao_Paulo');
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

        $produtos = $this->produto->limit(16)->orderBy('id', 'desc')->get();
        $produtosMaisVendidos = $this->produto->limit(8)->orderBy('avaliacao', 'desc')->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias', 'produtosMaisVendidos'));
    }

    public function produto($slug)
    {
        $produto = $this->produto->whereSlug($slug)->first();
        $comentariosRecentes = $produto->comentarios()->limit(5)->orderBy('id', 'desc')->get();
        $cliente = new Cliente();
        $favorito = new Favorito();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        if(session()->has('cliente')){
            $favorito = $favorito->where('produto', $produto->id)->where('cliente', session()->get('cliente')->id);
            return view('produto', compact('produto', 'comentariosRecentes', 'cliente', 'favorito', 'categorias'));   
        }else{
            return view('produto', compact('produto', 'comentariosRecentes', 'cliente', 'categorias'));   
        }
    }

    public function exibirPorCategoria($categoria)
    {
        $produtos = $this->produto->where('categoria', $categoria)->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));
    }

    public function buscaDeProdutos(Request $request)
    {

        $dados = $request->all();

        $produtos = $this->produto->where('nome', 'like', '%' . $dados['pesquisa_produt'] . '%')->get();
        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));
    }

    public function incrementarQuantidadeVendidaProduto()
    {
        $produtos = session()->get('carrinho');

        foreach ($produtos as $produto) {
            $this->produto = $this->produto->whereSlug($produto['slug'])->first();
            $avaliacao = (1 * $produto['quantidade']) + $this->produto->avaliacao;
            $this->produto->where('slug', $produto['slug'])->update(['avaliacao' => $avaliacao]);
        }

        session()->forget('carrinho');

        return;
    }

    public function exibicaoProdutosMaisVendidos()
    {
        $produtos = $this->produto->limit(8)->orderBy('avaliacao', 'desc')->get();

        $categoria = new Categoria();
        $categorias = $categoria->all();
        return view('welcome', compact('produtos', 'categorias'));
    }

    public function favoritos()
    {

        if(!session()->has('cliente')){
            return redirect()->back();
        }
            $favorito = new Favorito();
            $cliente = new Cliente();
            $cliente=$cliente->find(session()->get('cliente')->id);
            $produtos = $cliente->favoritos()->get();
    
            $categoria = new Categoria();
            $categorias = $categoria->all();
            return view('welcome', compact('produtos', 'categorias'));
        

    }

    public function reduzirDescricao($descricao){
        if(strlen($descricao)>85){
             echo substr($descricao, 0, 85)."...";
        }else{
            echo $descricao;
        }
        return ;
    }
}
