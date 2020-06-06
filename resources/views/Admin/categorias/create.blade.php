@extends('layouts.index')
@section('content')
<div class="form">
<form action="{{ route('admin.categoria.store') }}" method="post">
    @csrf
    <div class="form-group">
      <label for="nome">nome</label>
      <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}">

      @error('nome') <div class="invalid-feedback"> {{ $message }} </div> @enderror

    </div>
    <div class="form-group">
        <label for="descricao">Descricão</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') }}">

        @error('descricao') <div class="invalid-feedback"> {{ $message }} </div> @enderror

    </div>

    <button type="submit" class="btn btn-primary">cadastrar</button>
  </form>
</div>
@endsection