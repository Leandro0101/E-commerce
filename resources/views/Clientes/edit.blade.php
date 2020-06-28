@extends('layouts.index')
@section('content')
  {{-- Formulário de cadastro de novo cliente --}}
  @if(session('erro'))
      <div class="alert alert-danger" role="alert">
         {{ session('erro') }}
      </div>
  @endif
<div class="container">
  <div class="row pt-4 mt-2 justify-content-center align-items-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <form action="{{route('cliente.atualizacao', ['id' =>session()->get('cliente')->id])}}" class="form-group p-3" novalidate method="post" enctype="multipart/form-data">
            <h3 class="card-header text-center text-dark">Editar Conta</h3>
            @method('PUT')
            @csrf
          {{-- Campo nome --}}
            <div class="form-group row mt-4">
              <label for="Nome" class="text-dark">Nome:</label><br>
              <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="validationTooltip03" placeholder="Nome Completo" value="{{ session()->get('cliente')->nome }}">
              @error('nome')
                <div class="invalid-tooltip">
                  {{ $message }}
                </div>
                @enderror
            </div>
          {{-- Campo email --}}
            <div class="form-group row">
                <label for="email" class="text-dark">Email:</label><br>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="validationTooltip03" placeholder="exemplo@gmail.com" value="{{ session()->get('cliente')->email }}">
                @error('email')
                  <div class="invalid-tooltip">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            {{-- Campo senha atual --}}
            <div class="form-group row">
              <label for="senhaAtual" class="text-dark">Senha Atual:</label><br>
              <input type="password" name="senhaAtual" class="form-control" id="validationTooltip03" placeholder="Confirme sua senha atual">
            </div>
            {{-- Campo senha nova --}}
            <div class="form-group row">
              <label for="senhaNova" class="text-dark">Nova Senha:</label><br>
              <input type="password" name="senhaNova" class="form-control @error('senhaNova') is-invalid @enderror" id="validationTooltip03" placeholder="Digite sua nova senha (opcional)">
              @error('senhaNova')
                <div class="invalid-tooltip">
                  {{ $message }}
                </div>
              @enderror
            </div>
            {{-- Campo de confirmação da senha --}}
            <div class="form-group row">
              <label for="confSenhaNova" class="text-dark">Confirmar Senha:</label><br>
              <input type="password" name="confSenhaNova" class="form-control @error('confSenhaNova') is-invalid @enderror" id="validationTooltip03" placeholder="Confirme sua nova senha (opcional)">
              @error('confSenhaNova')
                <div class="invalid-tooltip">
                  {{ $message }}
                </div>
              @enderror
            </div>
            {{-- Campo de colocar a foto do perfil --}}
            <div class="row">
              <label>Foto de perfil</label>
                @if(isset(session()->get('cliente')->foto()->first()->path))
                  <img src="{{ asset('storage/'.session()->get('cliente')->foto()->first()->path) }}" alt="" class="img-fluid mt-3"> <br>
                  <a href="{{ route('cliente.removerFoto', ['cliente' => session()->get('cliente')]) }}" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i> <span>Remover Foto</span></a>
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
            <button type="submit" class="mt-3 btn bg-lg btn-warning" title="Alterar"><i class="fas fa-pen"></i> <span>Alterar Cliente</span></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
