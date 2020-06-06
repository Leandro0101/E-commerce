<?php

namespace App\Http\Controllers\admin;

use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    protected $categoria;

    public function __construct()
    {
        $this->categoria = new Categoria();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = $this->categoria->paginate(5);
        
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        $categoria = $this->criar_categoria($this->categoria, $request);

        $categoria->save();

        flash('Categoria criado com sucesso')->success();

        return redirect()->route('admin.categoria.index');
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
        $categoria = $this->categoria->find($id);
        return view('admin.categorias.edit', compact('categoria'));
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
        $dados = $request->all();
        $categoriaEditada = $this->categoria->find($id);
        $categoriaEditada->nome = $dados['nome'];
        $categoriaEditada->descricao = $dados['descricao'];

        $categoriaEditada->update($dados);

        flash('Catagoria modificada com sucesso')->success();

        return redirect()->route('admin.categoria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoriaDeletada = $this->categoria->find($id);

        $categoriaDeletada->delete($categoriaDeletada);

        flash('Categoria deletada com sucesso')->success();

        return redirect()->route('admin.categoria.index');
    }

    private function criar_categoria($categoria, CategoriaRequest $request){
        $dados = $request->all();

        $categoria->nome = $dados['nome'];
        $categoria->descricao = $dados['descricao'];

        return $categoria;
    }
}
