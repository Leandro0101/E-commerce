<?php 
  use App\Comentario;
  $comentario = new Comentario();
?>
@extends('layouts.index')
@section('stylesheet')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="container">
  @if($errors->count())
    @foreach($errors as $error)
      <div class="alert-warning">{{ $error }}</div>
    @endforeach
  @endif
{{-- Se o cliente estiver logado no sistema, ele zerá armazenado em $cliente --}}
  @if(session()->has('cliente'))
    @php
      $cliente = session()->get('cliente');
    @endphp
  @endif
<div class="row mt-5">
  <div class="col-5">
    <div class="card mb-3 mt-4" style="width:36rem;">
      <div class="row no-gutters">
        <div class="col-md-5">
          {{-- Se existir uma contagem de endereços de fotos, significa que a foto existe! --}}
          @if($produto->fotos->count())
          {{-- A foto princpal do Card recebe o primeiro valor do collection de fotos --}}
            <img src="{{ asset('storage/'.$produto->fotos->first()->path) }}" class="img-fluid" alt="...">
          {{-- Se o produto tiver mais de uma foto, essas fotos serão exibidas abaixo da primeira foro --}}
          @if($produto->fotos->count()>1)
            <div class="row">
              {{-- Passa todas as fotos da collection --}}
              <div class="col-9">
                <div id="carouselExampleControls" class="carousel slide carousel-fad ml-5" data-ride="carousel" style="height: 200px">
                  <div class="carousel-inner">
                    <div class="carousel-item active" data-interval="10">
                      <img src="{{ asset('storage/'.$produto->fotos->first()->path) }}" class="d-block w-100" alt="..." style="max-height: 200px">
                    </div>
                    @foreach ($produto->fotos as $foto)
                    <div class="carousel-item" data-interval="2500">
                      <img src="{{ asset('storage/'.$foto->path) }}" class="d-block w-100" alt="..." style="max-height: 200px">
                    </div>
                    @endforeach
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
            </div>
          @endif
          {{-- Se não haver contagem, quer dizer que o produto não tem foto, e então será atribuída uma imagem padrão para esse produto --}}
          @else
            <img src="{{ asset('storage/produtos/semfoto.png') }}" class="img-fluid" alt="...">
          @endif
        </div>
        <div class="col-6">
        <div class="col-md-12">
          <div class="card-body">
            <h4 class="card-title">{{ $produto->nome }}</h4>

            
            <div class="descricao">
              <p class="card-text text-muted ">{{ $produto->descricao }}</p>
            </div>
            
            
            <h5 class="card-title mt-5">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h5>
            <hr>
            <label for="">Quantidade</label>
            <div class="form-group">
              <form action="{{ route('carrinho.adicionar') }}" method="post">
                @csrf
                <input type="hidden" class="" name="produto[nome]" value="{{ $produto->nome }}">
                <input type="hidden" name="produto[preco]" value="{{ $produto->preco }}">
                <input type="hidden" name="produto[slug]" value="{{ $produto->slug }}">
                <input type="number" class="w-25" name="produto[quantidade]" value="1">
                <br>


                @guest
                @if ($produto->quantidade == 0)
                <img src="{{ asset('assets/img/estoquevazio.svg') }}" alt="" width="25px"><strong class="ml-2" style="font-size:18px;margin-top:17px;">Esgotado</strong>
                @else
                  <button type="submit" class="btn bg-light mt-3">Adicionar à sacola</button>    
                @endif
                @else
                <h5>Apenas clientes podem adicionar itens ao carrinho</h5>
                @endguest

                
                
              </form>


              @if(!isset($favorito) || !$favorito->count())
              @if(session()->has('cliente'))
              <form name="form_favorito" class="formFavorito">
                @csrf
                <button type="submit" class="btn btn-light mt-3"><i class="fas fa-crown">favoritar</i></button>
              </form>
              @endif
              @else
              <p>
                <a class="btn btn-light ml-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fas fa-crown">Meu favorito</i>    
                </a>
              </p>
                  <form action="{{ route('cliente.removerFavorito', ['id'=>$produto->id]) }}" method="POST"  class="collapse" id="collapseExample">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger ml-3 btn-sm" style="font-size: 13px;"><i class="fas fa-minus-circle">Remover favorito</i></button>
                  </form>  
              @endif   

              
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-2"></div>

  <div class="col-md-5">
    <form name="formComentario">
      @csrf
      <div class="form-group">
        <label for="exampleFormControlTextarea1"><strong></strong>Envie seu feedback!</label>
        <textarea name="comentario" id="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
      <div class="row">
        @if(session()->get('cliente'))
          <button type="submit" class="btn bg-light btn-sm ml-4">Comentar</button>
        @else
          <h6 class="ml-3"> <i class="fas fa-exclamation-circle"> Para enviar seu feedback, acesse sua conta</i> </h6>
        @endif
        <div class="alert-danger ml-4 py-1 d-none messageError" style="color:white;border-radius:6px;">
        </div>
      </div>
    </form>
    <hr>
    @foreach ($comentariosRecentes as $comentario)
    @php
        $id = $comentario->cliente;
        $cliente = $cliente->find($id);   
    @endphp
      <div class="toas" role="alert" style="overflow: hidden;">
        <div class="toast-header">
          @if(isset($cliente->foto()->first()->path))
            @php
              $foto = $cliente->foto()->first()->path;
            @endphp
            <img src="{{ asset('storage/'.$foto) }}" class="rounded mr-2" alt="..." width="25">
          @else
            <img src="{{ asset('assets/img/user_sem_foto.png') }}" class="rounded mr-2" alt="..." width="25">
          @endif
        
          <strong class="mr-auto" >{{ $cliente->nome }} <i class="far fa-comment-dots"></i></strong>
          <small class="text-muted" ><p style="white-space: pre-line;">{{ $comentario->created_at->format('d/m/Y') }}</p></small>
          
        </div>
        <div class="toast-body">
          {{ $comentario->texto }}
        </div>
      </div>
    @endforeach
    <button type="button" class="btn bg-light btn-sm ml-2" data-toggle="modal" data-target="#exampleModal"> Ver mais comentários </button>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">O que os clientes acham do(a) {{ $produto->nome }}?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @php
          $todosComentario = $comentario->where('produto', $produto->id)->get();
        @endphp
        @foreach ($todosComentario as $comentario)
        @php 
          $id = $comentario->cliente;
          $cliente = $cliente->find($id);
        @endphp
          <div class="toas" role="alert">
            <div class="toast-header">
              @if(isset($cliente->foto()->first()->path))
                @php
                  
        
                  $foto = $cliente->foto()->first()->path;
                  
                @endphp
                <img src="{{ asset('storage/'.$foto) }}" class="rounded mr-2" alt="..." width="25">
              @else
                <img src="{{ asset('assets/img/user_sem_foto.png') }}" class="rounded mr-2" alt="..." width="25">
              @endif
              <strong class="mr-auto">{{ $cliente->nome }} <i class="far fa-comment-dots"></i></strong>
              <small class="text-muted" >{{ $comentario->created_at->format('d/m/Y') }}</small>
            </div>
            <div class="toast-body" style="overflow: hidden;">
              {{ $comentario->texto }}
            </div>
          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Retornar</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script
src="https://code.jquery.com/jquery-2.2.4.min.js"
integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "3000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  }
</script>


<script>
  $(function(){
    $('form[name="form_favorito"').submit(function(event){
        event.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: '{{ route("cliente.favoritar", ["id" => $produto->id]) }}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
              toastr.info  ('Esse produto agora é um favorito', 'E-BIJU informa')
              $('.formFavorito').addClass('d-none');
            },
            error: function(error){
                console.log(error);
            }
        });
    })
});
</script>



<script>
  $(function () {
    $('form[name="formComentario"]').submit(function (event) {
      event.preventDefault();
      $.ajax({
        type: 'POST',
        url: '{{ route("comentario.adicionar", ["slug" => $produto->slug ]) }}',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success == false) {
            toastr.error  (response.message, 'E-BIJU informa')
          } else {
            toastr.success  ('Obrigado pelo feedback!', 'E-BIJU informa')
            $('textarea#comentario').val(" ");
          }
        }
      });
    });
  });
</script>
@endsection

