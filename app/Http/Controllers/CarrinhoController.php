<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrinhoController extends Controller
{

    public function index(){

        $carrinho = session()->has('carrinho') ? session()->get('carrinho') : [];

        return view('carrinho', compact('carrinho'));
    }

    public function adicionar(Request $request){
        $produto = $request->get('produto');

        if(session()->has('carrinho')){

            session()->push('carrinho', $produto);

        }else{

            $produtos[] = $produto;

            session()->put('carrinho', $produtos);
        }

        
        flash('Produto adicionado com êxito')->success();

        return redirect()->route('produto', ['slug' => $produto['slug']]);

    }
}
