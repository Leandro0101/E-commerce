@extends('layouts.index')
@section('content')
<div class="form">

    <form action="{{ route('admin.produto.update', ['produto' =>$produto->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
          <label for="nomeUp">nome</label>
          <input type="text" class="form-control @error('nomeUp') is-invalid @enderror" name="nomeUp" value="{{ $produto->nome }}">
          
          @error('nomeUp') <div class="invalid-feedback"> {{ $message }} </div> @enderror

        </div>
        <div class="form-group">
          <label for="quantidade">quantidade</label>
          <input type="number" class="form-control" name="quantidade" value="{{ $produto->quantidade }}">
        </div>
        <div class="form-group">
            <label for="descricao">Descricão</label>
            <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ $produto->descricao }}">

            @error('descricao') <div class="invalid-feedback"> {{ $message }} </div> @enderror
        
        </div>
        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" class="form-control @error('preco') is-invalid @enderror" name="preco" value="{{ $produto->preco }}">

            @error('preco') <div class="invalid-feedback"> {{ $message }} </div> @enderror

        </div>
        <div class="form-group">
            <label> Fotos do produto</label>
            <input type="file" class="form-control-file @error('fotos') is-invalid @enderror" id="exampleFormControlFile1" name="fotos[]" multiple>
            
            @error('fotos') <div class="invalid-feedback"> {{ $message }} </div> @enderror

        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
      </form>

      <div class="row">
        @foreach($produto->fotos as $foto)
        <div class="card ml-3 mt-2" style="width: 8rem;">
            <img src="{{asset('storage/'.$foto->path)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <form action="{{ route('admin.foto.delete') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $foto->path }}" name="nomeFoto">
                    <button class="btn btn-danger btn-sm ml-2" type="submit">deletar</button>
                </form>
            </div>
          </div>
        @endforeach
    </div>

    </div>

@endsection