<?php

namespace App\Http\Controllers;

use toastr;
use App\State;
use App\Cliente;
use App\Endereco;
use Illuminate\Http\Request;
use App\Http\Requests\EnderecoRequest;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = new State();

        $states = $state->all();

        return view('clientes.enderecos.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnderecoRequest $request)
    {
        $endereco = new Endereco();
        $endereco = $this->criarEndereco($request);
        $endereco->save();

        return redirect()->route('home');
    }

    public function criarEndereco($request)
    {
        $dados = $request->all();
        $endereco = new Endereco();
        $endereco->cliente = session()->get('cliente')->id;
        $endereco->estado = $dados['estado'];
        $endereco->cidade = $dados['cidade'];
        $endereco->bairro = $dados['bairro'];
        $endereco->endereco = $dados['endereco'];
        $endereco->numero = $dados['numero'];
        $endereco->complemento = $dados['complemento'];
        $endereco->cep = $dados['cep'];

        return $endereco;
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
    public function edit($idCliente)
    {
        $cliente = new Cliente();
        $cliente = $cliente->find($idCliente);

        if(!isset($cliente->endereco()->first()->id)){
            return redirect()->route('endereco.create');
        }
        
        $state = new State();

        $states = $state->all();
        return view('clientes.enderecos.edit', compact('cliente', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EnderecoRequest $request, $id)
    {
        $dados = $request->all();
        $endereco = new Endereco();
        $endereco = $endereco->find($id);

        
        $endereco->estado = $dados['endereco'];
        $endereco->cidade = $dados['cidade'];
        $endereco->bairro = $dados['bairro'];
        $endereco->endereco = $dados['endereco'];
        $endereco->numero = $dados['numero'];

        $endereco->update($dados);

        // toastr()->warning('My name is Inigo Montoya. You killed my father, prepare to die!');

        return redirect()->route('home');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
