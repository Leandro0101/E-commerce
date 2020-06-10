<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Produto;
use App\ClienteFoto;
use App\Traits\ProdutoTrait;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;

class ClienteController extends Controller
{
    use ProdutoTrait;

    private $cliente;
    private $produto;

    public function __construct()
    {
        
        $this->cliente = new Cliente();
        $this->produto = new Produto();
        
    }

    public function criar()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        $this->cliente = $this->criarCliente($request, $this->cliente);
        $this->cliente->save();

        if($request->hasFile('fotoCliente')){
            $file = $request->file('fotoCliente');

            $foto = $file->store('perfil_fotos', 'public');

            $clienteFoto = new ClienteFoto();
            $clienteFoto->path = $foto;
            $clienteFoto->cliente = $this->cliente->id;
            $clienteFoto->save();

        }
        
        $produtos = $this->produtos($this->produto);

        return view('welcome', compact('produtos'));
    }
    public function criarCliente($request, $cliente)
    {
        $dados = $request->all();

        $cliente->nome  = $dados['nome'];
        $cliente->email = $dados['email'];
        $cliente->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);

        return $cliente;
    }

    public function edit($id){

        if(!session()->has('cliente')){
            return redirect()->route('home');
        }else{
            $cliente = $this->cliente->findOrFail($id);

            return view('clientes.edit', compact('cliente'));
        }

    }

    public function login(Request $request)
    {
        if(session()->has('cliente')){
            return redirect()->route('home');
        }else{
            return view('clientes.login');
        }
    }

    public function autenticacao(Request $request)
    {
        $dados = $request->all();
        $email = $dados['email'];
        $senha = $dados['senha'];
        $cliente = $this->cliente->where('email', $email)->get()->first();

        if (!$cliente || !password_verify($senha, $cliente->senha)) {
            // return redirect()->back()->withInput()->withErrors(['E-mail ou senha incorretos']);
            $login['success'] = false;
            $login['message'] = 'Email ou senha incorretos';

            echo json_encode($login);

            return;
        } else {
            session()->put('cliente', $cliente);

            $login['success'] = true;
            //$login['message'] = 'Estão corretos';
            echo json_encode($login);

            return;

            //return redirect()->route('home');

        }
    }

    public function sair(){
        if(session()->has('cliente')){
            session()->forget('cliente');

            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }
}
