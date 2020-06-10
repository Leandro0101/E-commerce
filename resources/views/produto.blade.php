@extends('layouts.index')
@section('content')
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
    <form action="{{ route('comentario.adicionar', ['slug' => $produto->slug ]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Envie seu feedback!</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comentario">Esse é um comentário teste</textarea>
          </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<hr>
{{-- <a>{{ $cliente->comentarios()->first()->texto }}</a> --}}
</div>

</div>

@endsection