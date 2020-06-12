@extends('layouts.index')
@section('content')
  {{-- Formulário de cadastro de novo cliente --}}
  <form action="{{route('cliente.store')}}" class="needs-validation mt-5" novalidate method="POST" enctype="multipart/form-data">

    @csrf
  {{-- Campo nome --}}
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="validationTooltip03" placeholder="Nome Completo" value="{{ old('nome') }}">

        @error('nome')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror

      </div>
    </div>
  {{-- Campo email --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="validationTooltip03" placeholder="exemplo@gmail.com" value="{{ old('email') }}">
        
        @error('email')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror

      </div>
    </div>
    {{-- Campo senha --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="password" name="senha" class="form-control @error('senha') is-invalid @enderror" id="validationTooltip03" placeholder="senha">
        
        @error('senha')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror

      </div>
    </div>
    {{-- Campo de confirmação da senha --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="password" name="confSenha" class="form-control @error('confSenha') is-invalid @enderror" id="validationTooltip03" placeholder="confirme sua senha">
        
        @error('confSenha')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror

      </div>
    </div>
    {{-- Campo de colocar a foto do perfil --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <label>Foto de perfil</label>
        <input type="file" name="fotoCliente" class="form-control @error('fotoCliente') is-invalid @enderror" id="validationTooltip03">
        
        @error('fotoCliente')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror
      
      </div>
    </div>
    <button class="btn btn-primary mt-3" type="submit">Cadastrar</button>
  </form>
@endsection
