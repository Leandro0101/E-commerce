<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Comentario;
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

        return view('welcome', compact('produtos'));
    }

    public function produto($slug)
    {   
        $comentario = new Comentario();
        $produto = $this->produto->whereSlug($slug)->first();
        $comentarios = $produto->comentarios;

        dd($comentarios);

        return view('produto', compact('produto'));
    }
}
