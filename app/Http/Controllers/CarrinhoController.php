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

            $produtos = session()->get('carrinho');
            $slugProdutos = array_column($produtos, 'slug');

            if(in_array($produto['slug'], $slugProdutos)){
                $produtos = $this->incrementandoProduto($produtos, $produto['slug'], $produto['quantidade']);

                session()->put('carrinho', $produtos);
            }else{
                session()->push('carrinho', $produto);
            }

        }else{

            $produtos[] = $produto;

            session()->put('carrinho', $produtos);
        }

        
        flash('Produto adicionado com êxito')->success();

        return redirect()->route('produto', ['slug' => $produto['slug']]);

    }

    public function remover($slug){

        if(!session()->has('carrinho')){
            return redirect()->route('carrinho.carrinho');
        }else{

            $produtos = session()->get('carrinho');

            $produtos = array_filter($produtos, function($item) use ($slug){
                return $item['slug'] != $slug;
            });

            session()->put('carrinho', $produtos);


            return redirect()->route('carrinho.carrinho');

        }
        
    }

    public function cancelar(){
        session()->forget('carrinho');

        flash('Compra cancelada com êxito')->success();

        return redirect()->route('carrinho.carrinho');
    }

    private function incrementandoProduto($produtos, $slug, $quantidade){

        $produtos = array_map(function($linha) use($slug, $quantidade){
            if($slug == $linha['slug']){
                $linha['quantidade']+=$quantidade;
            }
            return $linha;
        }, $produtos );

        return $produtos;
    }
}
