@extends('layouts.index')
@section('content')

    <div class="col-12 mt-3">
        <h2>Carrinho de compras</h2>
    </div>
    <hr>
    @if($carrinho)
        
 
    <table class="table table-striped table-dark mt-5">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">valor</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Subtotal</th>
                <th scope="col">O que deseja fazer?</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $total = 0;
            @endphp
            @foreach ($carrinho as $c)
                <tr>
                    <th>{{ $c['nome'] }}</th>
                    <td>{{ $c['preco'] }}</td>
                    <td>{{ $c['quantidade'] }}</td>
                    @php 
                        $subtotal = $c['quantidade']*$c['preco'];
                    @endphp
                    <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                    @php
                        $total+= $subtotal;    
                    @endphp
                    <td>
                        <a href="{{ route('carrinho.remover', ['slug' => $c['slug']]) }}" type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i>Remover</a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total:</td>
                <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
            </tr>

        </tbody>
    </table>
    <hr>
    <div class="col-md-12">
        <a href="{{ route('carrinho.cancelar') }}" class="btn btn-danger float-left">Cancelar compra</a>
        <a href="{{ route('checkout.index') }}" class="btn btn-success float-right">Concluir compra</a>
    </div>
    @else
    <div class="col-12 mt-3">
        <div class="alert alert-warning">Carrinho vazio</div>
    </div>
    @endif


@endsection