@extends('layouts.index')
@section('content')
  <div class="container">
    <div class="col-md-10 mt-4">
			<h2>Produtos <b>#E-Biju</b></h2>
		</div>
    <a href="{{ route('admin.produto.create') }}" class="btn btn-success pull-right"  title="Add" data-toggle="tooltip"><i class="fas fa-plus"></i> <span>Adicione mais Produto</span></a>
    <table class="table table-hover mt-5">
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
                            <button type="submit" class="btn btn-sm btn-danger mr-1" title="Remover"><i class="fas fa-trash"></i> <span>Remover</span></button>
                        </form>
                        <a href="{{ route('admin.produto.edit', ['produto' =>$produto->id]) }}" class="btn btn-sm btn-warning" title="Alterar"><i class="fas fa-pen"></i> <span>Alterar</span></a>
                    </div>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      {{ $produtos->links() }}
  </div>
@endsection