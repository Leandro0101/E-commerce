<?php

namespace App\Http\Controllers;

use App\State;
use App\Cliente;
use App\Produto;
use App\Endereco;
use App\Favorito;
use App\ClienteFoto;
use App\HistoricoCompra;
use App\Traits\ProdutoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ClienteRegistroEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\EnderecoRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AtualizacaoClienteRequest;

date_default_timezone_set('America/Sao_Paulo');
class ClienteController extends Controller
{
    use ProdutoTrait;

    private $cliente;
    private $produto;
    private $foto;

    public function __construct()
    {

        $this->cliente = new Cliente();
        $this->produto = new Produto();
        $this->foto = new ClienteFoto();
    }

    public function criar()
    {
        $state = new State();

        $states = $state->all();

        return view('clientes.create', compact('states'));
    }

    public function store(ClienteRequest $request)
    {
        $this->cliente = $this->criarCliente($request, $this->cliente);
        $this->cliente->save();

        if ($request->hasFile('fotoCliente')) {
            $file = $request->file('fotoCliente');

            $foto = $file->store('perfil_fotos', 'public');

            $clienteFoto = new ClienteFoto();
            $clienteFoto->path = $foto;
            $clienteFoto->cliente = $this->cliente->id;
            $clienteFoto->save();
        }
        session()->put('cliente', $this->cliente);
        $cliente = new CLiente();
        Mail::to(session()->get('cliente')->email)->send(new ClienteRegistroEmail($cliente));
        
        return redirect()->route('endereco.create');
    }
    public function criarCliente($request, $cliente)
    {
        $dados = $request->all();

        $cliente->nome  = $dados['nome'];
        $cliente->email = $dados['email'];
        $cliente->cpf = $dados['cpf'];
        $cliente->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);

        return $cliente;
    }

    public function edit($id)
    {

        if (!session()->has('cliente')) {
            return redirect()->route('home');
        } else {
            $cliente = $this->cliente->findOrFail($id);

            return view('clientes.edit', compact('cliente'));
        }
    }

    public function atualizacao(AtualizacaoClienteRequest $request, $id)
    {
        $this->cliente = $this->cliente->find(session()->get('cliente')->id);
        $dados = $request->all();
        if ($this->verificaDuplicidadeEmail($this->cliente->email, $dados['email']) == false) {
            return redirect()->back()->with('erro', 'Email em uso');
        }

        $senhaNova = $dados['senhaNova'];
        $confsenhaAtual = $dados['senhaAtual'];
        $senhaAtual = $this->cliente->senha;

        if ($senhaNova == "") {
            $senhaNova = $senhaAtual;
            $this->cliente->senha = $senhaNova;
        } else {
            $this->cliente->senha = password_hash($senhaNova, PASSWORD_DEFAULT);
            if (strlen($senhaNova) < 8) {
                return redirect()->back()->with('erro', 'Senha muito curta');
            }
        }

        if (!password_verify($confsenhaAtual, $senhaAtual)) {
            return redirect()->back()->with('erro', 'Senha incorreta');
        } else {

            $this->cliente->nome = $dados['nome'];
            $this->cliente->email = $dados['email'];
            $this->cliente->update($dados);

            if ($request->hasFile('fotoCliente')) {
                $file = $request->file('fotoCliente');

                if (isset(session()->get('cliente')->path)) {
                    $this->removerFoto($this->cliente);
                }

                $foto = $file->store('perfil_fotos', 'public');


                $this->foto->path = $foto;
                $this->foto->cliente = $this->cliente->id;
                $this->foto->save();
            }
            session()->forget('cliente');
            session()->put('cliente', $this->cliente);
            return redirect()->route('home');
        }
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect()->back();
        }

        if (session()->has('cliente')) {
            return redirect()->back();
        } else {
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
            if (session()->get('carrinho')) {
                $login['carrinho'] = true;
            } else {
                $login['carrinho'] = false;
            }
            echo json_encode($login);

            return;

        }
    }

    public function sair()
    {
        if (session()->has('cliente')) {
            session()->forget('cliente');

            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }

    public function removerFoto(Cliente $cliente)
    {
        $this->foto = $cliente->foto()->first();
        $foto = $this->foto->path;
        Storage::disk('public')->delete($foto);
        $this->foto->delete($this->foto);

        return redirect()->back();
    }

    public function verificaDuplicidadeEmail($emailAtual, $emailNovo)
    {
        $cliente = new Cliente();
        $cliente = $this->cliente->where('email', $emailNovo);

        if ($cliente->count()) {
            if ($cliente->first()->email != $emailAtual) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function favoritar(Request $request, $id)
    {
        $favorito = new Favorito();
        $this->produto = $this->produto->find($id);
        $cliente = session()->get('cliente');

        $favoritoJaExiste = $favorito->where('produto', $this->produto->id)->where('cliente', $cliente->id)->first();

        if (isset($favoritoJaExiste)) {
        } else {
            $favorito->produto = $this->produto->id;
            $favorito->cliente = $cliente->id;
            $favorito->save();
        }


        $favoritar['success'] = true;

        echo json_encode($favoritar);

        return;
    }

    public function removerFavorito($id)
    {

        if (!session()->has('cliente')) {
            return redirect()->back();
        }

        $favorito = new Favorito();
        $cliente = session()->get('cliente');
        $favorito = $favorito->where('produto', $id)->where('cliente', $cliente->id)->first();
        $favorito->delete($favorito);

        return redirect()->route('favoritos');
    }
}
