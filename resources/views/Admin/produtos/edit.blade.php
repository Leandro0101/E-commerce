@extends('layouts.index')
@section('content')
  <div class="container">
    <div class="mt-4">
	    <h2>Atualizar Produto <b>#E-Biju</b></h2>
	  </div>
    <form action="{{ route('admin.produto.update', ['produto' =>$produto->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
          <label for="nomeUp">Nome</label>
          <input type="text" class="form-control @error('nomeUp') is-invalid @enderror" name="nomeUp" value="{{ $produto->nome }}">
          @error('nomeUp') <div class="invalid-feedback"> {{ $message }} </div> @enderror
        </div>
        <div class="form-group">
          <label for="quantidade">Quantidade</label>
          <input type="number" class="form-control col-1" name="quantidade" value="{{ $produto->quantidade }}">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ $produto->descricao }}">
            @error('descricao') <div class="invalid-feedback"> {{ $message }} </div> @enderror
        </div>
        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" class="form-control col-1 @error('preco') is-invalid @enderror" name="preco" value="{{ $produto->preco }}">
            @error('preco') <div class="invalid-feedback"> {{ $message }} </div> @enderror
        </div>

        <div class="form-group">
          <label>Categorias</label>
  
          <select name="categoria" id="" class="form-control" multiple>
              @foreach($categorias as $categoria)
              <option value="{{ $categoria->id }}" @if($produto->categoria==$categoria->id) selected @endif
                  >{{ $categoria->nome }}</option>
              @endforeach
          </select>
      </div>

        <div class="form-group">
            <label> Fotos do produto</label>
            <input type="file" class="form-control-file @error('fotos.*') is-invalid @enderror" id="exampleFormControlFile1" name="fotos[]" multiple>
            
            @error('fotos.*') {{ $message }}  @enderror
        </div>
        <button type="submit" class="btn bg-lg btn-warning" title="Alterar"><i class="fas fa-pen"></i> <span>Alterar Produto</span></button>
      </form>
      <div class="row">
        @foreach($produto->fotos as $foto)
        <div class="card ml-3 mt-2">
            <img src="{{asset('storage/'.$foto->path)}}" class="card-img-top" alt="..." style="max-width: 150px;">
            <div class="card-body">
                <form action="{{ route('admin.foto.delete') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $foto->path }}" name="nomeFoto">
                    <button type="submit" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i> <span>Remover</span></button>
                </form>
            </div>
          </div>
        @endforeach
    </div>
  </div>
@endsection