<?php

namespace App\Http\Controllers\admin;

use App\Produto;
use App\Categoria;
use App\ProdutoFoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Http\Requests\ProdutoUpdateRequest;

class ProdutoController extends Controller
{
    private $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produto->paginate(6);
        $categoria = new Categoria();
        return view('admin.produtos.index', compact('produtos', 'categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = new Categoria();
        $categorias = $categoria->all(['id', 'nome']);
        return view('admin.produtos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    { 
        $this->produto = $this->criar_produto($this->produto, $request);
        $this->produto->save();

        if($request->hasFile('fotos')){
            $this->uploadFotos($request);
        }

        
        flash('Produto criado com sucesso')->success();

        return redirect()->route('admin.produto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = new Categoria();
        $produto = $this->produto->find($id);
        $categorias = $categoria->all(['id', 'nome']);

        return view('admin.produtos.edit', compact('produto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoUpdateRequest $request, $id)
    {
        
        $data = $request->all();

        $produtoAtualizado = $this->produto->find($id);
        $produtoAtualizado->nome = $data['nomeUp'];
        $produtoAtualizado->quantidade = $data['quantidade'];
        $produtoAtualizado->preco = $data['preco'];
        $produtoAtualizado->descricao = $data['descricao'];
        $produtoAtualizado->categoria = $data['categoria'];
        $produtoAtualizado->update($data);

        $this->produto = $produtoAtualizado;

        if($request->hasFile('fotos')){
            $this->uploadFotos($request);
        }

        flash('Produto atualizado com sucesso')->success();

        return redirect()->route('admin.produto.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produtoDeletado = $this->produto->find($id);
        $produtoDeletado->delete($produtoDeletado);

        flash('Produto removido com sucesso')->success();

        return redirect()->route('admin.produto.index');
    }

    private function criar_produto($produto, ProdutoRequest $request){
        $dados = $request->all();

        $produto->nome = $dados['nome'];
        $produto->categoria = $dados['categoria'];
        $produto->descricao = $dados['descricao'];
        $produto->preco = $dados['preco'];
        $produto->quantidade = $dados['quantidade'];

        return $produto;
    }

    private function uploadFotos(Request $request){
        for($i = 0; $i < count($request->allFiles()['fotos']); $i++){
    
            $file = $request->allFiles()['fotos'][$i];

            $produtoFoto = new ProdutoFoto();
            $produtoFoto->produto = $this->produto->id;
            $produtoFoto->path = $file->store('produtos', 'public');
            $produtoFoto->save();

            unset($produtoFoto);
        }

    }

    public function descontarQtdEstoque(){
        $produtos = session()->get('carrinho');

        foreach($produtos as $produto){
            $this->produto = $this->produto->whereSlug($produto['slug'])->first();
            $quantidade_comprada = $produto['quantidade'];
            $quantidade_atual = $this->produto->quantidade;
            $nova_quantidade = $quantidade_atual-$quantidade_comprada;
            $this->produto->where('slug', $produto['slug'])->update(['quantidade' => $nova_quantidade]);
        }
        return;
    }

}
