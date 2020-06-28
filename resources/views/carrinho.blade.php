@extends('layouts.index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 mt-4">
                <h2>Carrinho de Compras <b>#E-Biju</b></h2>
            </div>
        </div>
        @if($carrinho)
        <table class="table table-hover">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">valor</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Ação</th>
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
                            $total += $subtotal;    
                        @endphp
                        <td>
                            <a href="{{ route('carrinho.remover', ['slug' => $c['slug']]) }}" type="submit" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i> <span>Remover</span></a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Total:</td>
                    <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                </tr>

            </tbody>
        </table>
        <div class="col-md-12">
            <a href="{{ route('checkout.index') }}" class="btn btn-success"><i class="fas fa-check"></i><span> Concluir Compra</span></a>
            <a href="{{ route('carrinho.cancelar') }}" class="btn btn-danger ml-2"><i class="fas fa-times"></i><span> Cancelar Compra</span></a>
        </div>
        @else
        <div class="col-12 mt-3">
            <div class="alert alert-warning">Carrinho vazio</div>
        </div>
        @endif
    </div>
@endsection