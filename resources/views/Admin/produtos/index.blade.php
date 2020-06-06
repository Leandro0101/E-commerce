@extends('layouts.index')
@section('content')
<h1 align="center">Tabela Produtos</h1>
<a href="{{ route('admin.produto.create') }}" class="btn btn-success">Cadastrar produto</a>
<table class="table table-striped table-dark mt-5">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">Quantidade</th>
        <th scope="col">Descrição</th>
        <th scope="col">Preço</th>
        <th scope="col">Categoria</th>
        <th scope="col">O que deseja fazer?</th>
      </tr>
    </thead>
    <tbody>
        
        @foreach ($produtos as $produto)
        <tr>
            <th>{{ $produto->nome }}</th>
            <td>{{ $produto->quantidade }}</td>
            <td>{{ $produto->descricao }}</td>
            <td>{{ $produto->preco }}</td>
            @php
              $categoria = $categoria->find($produto->categoria);
            @endphp
            <td>{{ $categoria->nome }}</td>
            <td>
                <div class="btn-group">
                    <form action="{{ route('admin.produto.destroy', ['produto' => $produto->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> deletar</button>
                    </form>
                    <a href="{{ route('admin.produto.edit', ['produto' =>$produto->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen-alt"></i> atualizar</a>
                </div>
            </td>
          </tr>
        @endforeach

    </tbody>
  </table>

  {{ $produtos->links() }}

@endsection