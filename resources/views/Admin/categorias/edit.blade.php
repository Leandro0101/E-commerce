@extends('layouts.index')
@section('content')
<div class="form">
<form action="{{ route('admin.categoria.update', ['categorium' => $categoria->id]) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group">
      <label for="nome">nome</label>
      <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $categoria->nome }}">

      @error('nome') <div class="invalid-feedback"> {{ $message }} </div> @enderror

    </div>
    <div class="form-group">
        <label for="descricao">Descricão</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ $categoria->descricao }}">

        @error('descricao') <div class="invalid-feedback"> {{ $message }} </div> @enderror

    </div>
    
    <button type="submit" class="btn btn-primary">atualizar</button>
  </form>
</div>
@endsection