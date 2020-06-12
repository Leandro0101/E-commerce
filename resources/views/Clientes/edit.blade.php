@extends('layouts.index')
@section('content')
  {{-- Formulário de cadastro de novo cliente --}}
  @if(session('erro'))
      <div class="alert alert-danger" role="alert">
         {{ session('erro') }}
      </div>
  @endif
  <form action="{{route('cliente.atualizacao', ['id' =>session()->get('cliente')->id])}}" class="needs-validation mt-5" novalidate method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
  {{-- Campo nome --}}
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="validationTooltip03" placeholder="Nome Completo" value="{{ session()->get('cliente')->nome }}">
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
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="validationTooltip03" placeholder="exemplo@gmail.com" value="{{ session()->get('cliente')->email }}">
        @error('email')
          <div class="invalid-tooltip">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    {{-- Campo senha atual --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="password" name="senhaAtual" class="form-control" id="validationTooltip03" placeholder="Confirme sua senha atual">
      </div>
    </div>
    {{-- Campo senha nova --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="password" name="senhaNova" class="form-control @error('senhaNova') is-invalid @enderror" id="validationTooltip03" placeholder="Digite sua nova senha (opcional)">
        @error('senhaNova')
        <div class="invalid-tooltip">
          {{ $message }}
        </div>
      @enderror

      </div>
    </div>
    {{-- Campo de confirmação da senha --}}
    <div class="form-row mt-4">
      <div class="col-md-4 mb-3">
        <input type="password" name="confSenhaNova" class="form-control @error('confSenhaNova') is-invalid @enderror" id="validationTooltip03" placeholder="confirme sua nova senha (opcional)">
        @error('confSenhaNova')
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
        @if(isset(session()->get('cliente')->foto()->first()->path))
        <a href="{{ route('cliente.removerFoto', ['cliente' => session()->get('cliente')]) }}" class="btn btn-danger">Remover foto</a>
        <img src="{{ asset('storage/'.session()->get('cliente')->foto()->first()->path) }}" alt="" width="50" style="border-radius: 100%">
        @else
        <div class="alert alert-warning" role="alert">
          Perfil sem foto
        </div>
        @endif
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
