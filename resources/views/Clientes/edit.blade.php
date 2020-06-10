@extends('layouts.index')
@section('content')
<div class="form col-4">
<form action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="nome">Nome completo</label>
      <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $cliente->nome }}">
    <input type="hidden" value="asjdkdj">

      @error('nome')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror

    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $cliente->email }}">

      
      @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror

    </div>
    <div class="form-group">
      <label for="senha">Senha</label>
      <input type="password" class="form-control @error('senha') is-invalid @enderror" name="senha" value="{{ old('senha') }}">

      
      @error('senha')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group">
        <label for="confSenha">Confirme sua senha</label>
        <input type="password" class="form-control @error('confSenha') is-invalid @enderror" name="confSenha" value="{{ old('confSenha') }}">
        
        @error('confSenha')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group">
      <label>Imagem de perfil</label>
      <input type="file" name="fotosCliente[]" class="form-control-file">
    </div>
    <button type="submit" class="btn btn-primary">cadastrar</button>
  </form>
</div>

@endsection