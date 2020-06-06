<?php

namespace App\Http\Controllers;

use App\Produto;
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
        $produto = $this->produto->whereSlug($slug)->first();

        return view('produto', compact('produto'));
    }
}
