@extends('layouts.index')
@section('content')
<h1 align="center">Tabela de categorias</h1>
<a href="{{ route('admin.categoria.create') }}" class="btn btn-success">Cadastrar categoria</a>
<table class="table table-striped table-dark mt-5">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">Descrição</th>
        <th scope="col">O que deseja fazer?</th>
      </tr>
    </thead>
    <tbody>
        
        @foreach ($categorias as $categoria)
        <tr>
            <th>{{ $categoria->nome }}</th>
            <td>{{ $categoria->descricao }}</td>
            <td>
                <div class="btn-group">
                    <form action="{{ route('admin.categoria.destroy', ['categorium' => $categoria->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> deletar</button>
                    </form>
                    <a href="{{ route('admin.categoria.edit', ['categorium' =>$categoria->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen-alt"></i> atualizar</a>
                </div>
            </td>
          </tr>
        @endforeach

    </tbody>
  </table>

  {{ $categorias->links() }}

@endsection