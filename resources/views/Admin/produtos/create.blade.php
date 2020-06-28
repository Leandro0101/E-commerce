@extends('layouts.index')
@section('content')
  <div class="container">
  <form action="{{ route('admin.produto.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}">
        @error('nome') <div class="invalid-feedback"> {{ $message }} </div> @enderror
      </div>
      <div class="form-group">
        <label for="quantidade">Quantidade</label>
        <input type="number" class="form-control col-1 @error('quantidade') is-invalid @enderror" name="quantidade" value="{{ old('quantidade') }}">
      </div>
      <div class="form-group">
          <label for="descricao">Descrição</label>
          <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') }}">
          @error('descricao') <div class="invalid-feedback"> {{ $message }} </div> @enderror
      </div>
      <div class="form-group">
          <label for="preco">Preço</label>
          <input type="text" class="form-control col-1 @error('preco') is-invalid @enderror" name="preco" value="{{ old('preco') }}">
          @error('preco') <div class="invalid-feedback"> {{ $message }} </div> @enderror
      </div>
      <div class="form-group">
        <label>Categorias</label>
        <select name="categoria" id="" class="form-control">
            @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group">
        <label> Fotos do produto</label>
        <input type="file" name="fotos[]" class="form-control-file @error('fotos.*') is-invalid @enderror" multiple>
  
        @error('fotos.*') <div class="invalid-feedback"> {{ $message }} </div> @enderror
  
    </div>
      <button type="submit" class="btn bg-lg btn-success">Criar Produto</button>
    </form>
  </div>
@endsection