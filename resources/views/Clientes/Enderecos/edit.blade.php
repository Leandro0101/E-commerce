@extends('layouts.index')
@section('content')
  <div class="container">
    <div class="row pt-5 mt-3 justify-content-center align-items-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            {{-- Formulário de cadastro de novo cliente --}}
            <form action="{{route('endereco.update', ['endereco' => $cliente->endereco()->first()->id ])}}" class="foem-group p-3 needs-validation mt-5" novalidate method="POST">
             <h3 class="card-header text-center text-dark">Onde você mora?</h3>
             @csrf
             @method('put')

            {{-- Campo nome --}}
                
                <div class="form-group mt-3">
                    <div class="col-md-12 mb-3">
                    <input type="text" name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" id="bairro" placeholder="exemplo: CE" value="{{ $cliente->endereco()->first()->estado }}">
                    @error('estado')
                        <div class="invalid-tooltip">
                        {{ $message }}
                        </div>
                    @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <input type="text" name="cidade" class="form-control @error('cidade') is-invalid @enderror" id="cidade" placeholder="cidaed" value="{{ $cliente->endereco()->first()->cidade }}">
                        @error('cidade')
                            <div class="invalid-tooltip">
                            {{ $message }}
                            </div>
                        @enderror
                        </div>

                </div>

              <div class="form-group mt-3">
                <div class="col-md-12 mb-3">
                  <input type="text" name="bairro" class="form-control @error('bairro') is-invalid @enderror" id="bairro" placeholder="bairro" value="{{ $cliente->endereco()->first()->bairro }}">
                  @error('bairro')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

              <div class="form-group mt-3">
                <div class="col-md-12 mb-3">
                  <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror" id="endereco" placeholder="endereço" value="{{ $cliente->endereco()->first()->endereco }}">
                  @error('endereco')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

            {{-- Campo email --}}
              <div class="form-group">
                <div class="col-md-12 mb-3">
                  <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" id="numero" placeholder="número" value="{{ $cliente->endereco()->first()->numero }}">
                    @error('numero')
                    <div class="invalid-tooltip">
                      {{ $message }}
                    </div>  
                    @enderror
                </div>
              </div>
              {{-- Campo senha --}}
              <div class="form-group ">
                <div class="col-md-12 mb-3">
                  <input type="text" name="complemento" class="form-control" placeholder="complemento" value="{{ $cliente->endereco()->first()->complemento }}">
                </div>
              </div>
              {{-- Campo de confirmação da senha --}}
              <div class="form-group ">
                <div class="col-md-12 mb-3">
                <input type="text" name="cep" class="form-control @error('cep') is-invalid @enderror" id="cep" placeholder="cep" value="{{ $cliente->endereco()->first()->cep }}">
                @error('cep')
                  <div class="invalid-tooltip">
                    {{ $message }}
                  </div>
                @enderror
                </div>
              </div>
              {{-- Campo de colocar a foto do perfil --}}
              <div class="row">
                <div class="col-7">
                    <button class="row btn bg-light btn-lg ml-3 mb-3" type="submit">Atualizar</button>
                </div>
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
