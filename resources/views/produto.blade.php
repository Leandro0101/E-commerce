<?php 
  use App\Comentario;
  $comentario = new Comentario();
?>

@extends('layouts.index')
@section('content')
{{-- Se o cliente estiver logado no sistema, ele zerá armazenado em $cliente --}}
  @if(session()->has('cliente'))
    @php
      $cliente = session()->get('cliente');
    @endphp
  @endif
<div class="row ">
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
                <div id="carouselExampleControls" class="carousel slide carousel-fad" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active" data-interval="10">
                      <img src="{{ asset('storage/'.$produto->fotos->first()->path) }}" class="d-block w-100" alt="...">
                    </div>
                    @foreach ($produto->fotos as $foto)
                    <div class="carousel-item" data-interval="2500">
                      <img src="{{ asset('storage/'.$foto->path) }}" class="d-block w-100" alt="...">
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
        <div class="col-md-7">
          <div class="card-body">
            <h2 class="card-title">{{ $produto->nome }}</h2>
            <h5 class="card-text text-muted">{{ $produto->descricao }}</h5>
            <h3 class="card-title mt-5">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h3>
            <hr>
            <label for="">Quantidade</label>
            <div class="form-group">
              <form action="{{ route('carrinho.adicionar') }}" method="post">
                @csrf
                <input type="hidden" name="produto[nome]" value="{{ $produto->nome }}">
                <input type="hidden" name="produto[preco]" value="{{ $produto->preco }}">
                <input type="hidden" name="produto[slug]" value="{{ $produto->slug }}">
                <input type="number" name="produto[quantidade]" value="1">
                <button type="submit" class="btn btn-outline-info mt-4">Adicionar à sacola</button>
              </form>
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
        <label for="exampleFormControlTextarea1">Envie seu feedback!</label>
        <textarea name="comentario" id="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
      <div class="row">

        @if(session()->get('cliente'))
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        @else
          <h5 style="font-size:15px;"> <i class="fas fa-exclamation-circle">Para enviar seu feedback, acesse sua conta</i> </h5>
        @endif

        <div class="alert-danger ml-4 py-1 d-none messageError" style="color:white;border-radius:6px;">

        </div>
      </div>
    </form>
    <hr>
    @foreach ($comentariosRecentes as $comentario)
      <div class="toas" role="alert">
        <div class="toast-header">
          @if(isset($cliente->foto()->first()->path))
            @php
              $id = $comentario->cliente;
              $cliente = $cliente->find($id);
              $foto = $cliente->foto()->first()->path;
            @endphp
            <img src="{{ asset('storage/'.$foto) }}" class="rounded mr-2" alt="..." width="25">
          @else
            <img src="{{ asset('assets/img/user_sem_foto.png') }}" class="rounded mr-2" alt="..." width="25">
          @endif
          <strong class="mr-auto">{{ $cliente->nome }} <i class="far fa-comment-dots"></i></strong>
          <small class="text-muted">{{ $comentario->created_at->format('d/m/Y') }}</small>
          
        </div>
        <div class="toast-body">
          {{ $comentario->texto }}
        </div>
      </div>
    @endforeach
    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#exampleModal"> Ver mais comentários </button>
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
          <div class="toas" role="alert">
            <div class="toast-header">
              @if(isset($cliente->foto()->first()->path))
                @php
                  $id = $comentario->cliente;
                  $cliente = $cliente->find($id);
                  $foto = $cliente->foto()->first()->path;
                @endphp
                <img src="{{ asset('storage/'.$foto) }}" class="rounded mr-2" alt="..." width="25">
              @else
                <img src="{{ asset('assets/img/user_sem_foto.png') }}" class="rounded mr-2" alt="..." width="25">
              @endif
              <strong class="mr-auto">{{ $cliente->nome }} <i class="far fa-comment-dots"></i></strong>
              <small class="text-muted">{{ $comentario->created_at->format('d/m/Y') }}</small>
            </div>
            <div class="toast-body">
              {{ $comentario->texto }}
            </div>
          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">retornar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

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
            $('.messageError').removeClass('d-none').html(response.message);
            $('.messageError').addClass('bg-danger').html(response.message);
          } else {
            $('.messageError').removeClass('bg-danger').html(response.message);
            $('.messageError').removeClass('d-none').html(response.message);
            $('.messageError').addClass('bg-success').html(response.message);
            $('textarea#comentario').val(" ");
          }
        }
      });
    });
  });
</script>
@endsection