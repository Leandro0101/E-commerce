@extends('layouts.index')
@section('content')
  <div class="container">
    <div class="row pt-5 mt-3 justify-content-center align-items-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            {{-- Formulário de cadastro de novo cliente --}}
            <form action="{{route('cliente.store')}}" class="foem-group p-3 needs-validation mt-5" novalidate method="POST" enctype="multipart/form-data">
             <h3 class="card-header text-center text-dark">Registro</h3>
              @csrf
            {{-- Campo nome --}}
              <div class="form-group row mt-3">
                <div class="col-md-12 mb-3">
                  <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="validationTooltip03" placeholder="Nome Completo" value="{{ old('nome') }}">
                  @error('nome')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

              <div class="form-group row mt-3">
                <div class="col-md-12 mb-3">
                  <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror" id="cpf" placeholder="CPF" value="{{ old('cpf') }}">
                  @error('cpf')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

            {{-- Campo email --}}
              <div class="form-group row">
                <div class="col-md-12 mb-3">
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="validationTooltip03" placeholder="exemplo@gmail.com" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>  
                    @enderror
                </div>
              </div>
              {{-- Campo senha --}}
              <div class="form-group row">
                <div class="col-md-12 mb-3">
                  <input type="password" name="senha" class="form-control @error('senha') is-invalid @enderror" id="validationTooltip03" placeholder="Senha">
                  @error('senha')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              {{-- Campo de confirmação da senha --}}
              <div class="form-group row">
                <div class="col-md-12 mb-3">
                <input type="password" name="confSenha" class="form-control @error('confSenha') is-invalid @enderror" id="validationTooltip03" placeholder="Confirme sua Senha">
                @error('confSenha')
                  <div class="invalid-tooltip">
                    {{ $message }}
                  </div>
                @enderror
                </div>
              </div>
              {{-- Campo de colocar a foto do perfil --}}
              <div class="form-group row">
                <div class="col-md-12 mb-3">
                  <input type="file" name="fotoCliente" class="form-control @error('fotoCliente') is-invalid @enderror" id="validationTooltip03">
                  @error('fotoCliente')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <button class="row btn bg-light btn-lg ml-3 mb-3" type="submit">Cadastrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')


<script>
  const urlCidadesPorEstado = '{{route("checkout.cidadesPorEstados")}}';
</script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/js/mascaras.js') }}"></script>
<script src="{{ asset('assets/js/cidades.js') }}"></script>

@endsection
