@extends('layouts.index')
@section('content')

    <div class="col-12 mt-3">
        <h2>Carrinho de compras</h2>
    </div>
    <hr>
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
                        <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i>Remover</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total:</td>
                <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
    

        </tbody>
    </table>


@endsection