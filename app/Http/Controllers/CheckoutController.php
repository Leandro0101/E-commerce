<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\ProdutoController;

class CheckoutController extends Controller
{
    public function index()
    {
        session()->forget('pagseguro_session_code');

        if (!session()->has('cliente')) {
            return redirect()->route('cliente.login');
        }

        $this->makePagSeguroSession();

        $cartItems = array_map(function ($line) {
            return $line['quantidade'] * $line['preco'];
        }, session()->get('carrinho'));

        $cartItems = array_sum($cartItems);

        $state = new State();

        $states = $state->all();
        
        return view('checkout', compact('cartItems', 'states'));
    }

    public function proccess(Request $request)
    {
        $dataPost = $request->all();

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

        
        
        
        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL'));

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $creditCard->setReference("LIBPHP000001");

        // Set the currency
        $creditCard->setCurrency("BRL");

        // Add an item for this payment request
        $itensCarrinho = session()->get('carrinho');
        foreach($itensCarrinho as $item){
            $creditCard->addItems()->withParameters(
                '0001',
                $item['nome'],
                $item['quantidade'],
                $item['preco']
            );
        }

        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $creditCard->setSender()->setName(session()->get('cliente')->nome);
        $creditCard->setSender()->setEmail('teste@sandbox.pagseguro.com.br');

        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '74143014432'
        );

        $creditCard->setSender()->setHash($dataPost['hash']);

        $creditCard->setSender()->setIp('127.0.0.0');

        // Set shipping information for this payment request
        $creditCard->setShipping()->setAddress()->withParameters(
            $dataPost['endereco'],
            $dataPost['numero'],
            $dataPost['bairro'],
            $dataPost['cep'],
            $dataPost['cidade'],
            $dataPost['estado'],
            'BRA',
            $dataPost['complemento']
        );

        //Set billing information for credit card
        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        // Set credit card token
        $creditCard->setToken($dataPost['card_token']);
        list($quantity, $installmentAmount) = explode('|', $dataPost['installment']);

        $installmentAmount = number_format($installmentAmount, 2, '.', '');

        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);

        // Set the credit card holder information
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName(session()->get('cliente')->nome); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '74143014432'
        );

        // Set the Payment Mode for this payment request
        $creditCard->setMode('DEFAULT');
        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        $home_controll = new HomeController();
        $produto_controller = new ProdutoController();
        $produto_controller->descontarQtdEstoque();
        $home_controll->incrementarQuantidadeVendidaProduto();
    
    }

    private function makePagSeguroSession()
    {
        if (!session()->has('pagseguro_session_code')) {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }

    public function cidadesPorEstados(Request $request){
        $dados = $request->all();
        $abbreviation = $dados['estado'];
        $estado = new State();
        $estado = $estado->where('abbreviation', $abbreviation)->first();
        $cidade = new City();
        $cidades = $estado->cities()->get();

        $response['success'] = true;
        $response['id'] = $estado;
        $response['cidades'] = $cidades;

        echo json_encode($response);

        return;

        
    }
    
}
