<?php 
use  App\Http\Controllers\HomeController;
$ctrlHome = new HomeController();
?>
@extends('layouts.index')

@section('title')
  E-Biju | Viva a Moda | Feminina, masculina, e infantil.
@endsection

@section('content')
<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" style>
      <div class="mask flex-center">
        <div class="container">
          <div class="row align-items-center mt-5">
            <div class="col-md-7 col-12 order-md-1 order-2">
              <h4>Bijuterias da moda <br>
                para o seu look! </h4>
              <p>Veio aqui pra conhecer a última moda em bijouterias e acessórios?<br>
                 Sinta-se em casa! Na página  você vai encontrar todas as bijuterias da moda.</p>
              <a class="btn" href="#" style="background-color: black;" >Produtos</a> </div>
            <div class="col-md-5 col-12 order-md-2 order-1"><img src="{{asset('assets/img/img-2.png')}}" class="mx-auto" alt="slide"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="mask flex-center">
        <div class="container">
          <div class="row align-items-center mt-5">
            <div class="col-md-7 col-12 order-md-1 order-2">
              <h4>Bijuterias da moda <br>
                para o seu look! </h4>
              <p>Veio aqui pra conhecer a última moda em bijouterias e acessórios?<br>
                 Sinta-se em casa! Na página  você vai encontrar todas as bijuterias da moda.</p>
                 <a class="btn" href="#" style="background-color: black;">Produtos</a> </div>
            <div class="col-md-5 col-12 order-md-2 order-1"><img src="{{asset('assets/img/img-1.png')}}" class="mx-auto" alt="slide"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="mask flex-center">
        <div class="container">
          <div class="row align-items-center mt-3">
            <div class="col-md-7 col-12 order-md-1 order-2">
              <h4>Bijuterias da moda <br>
                para o seu look! </h4>
              <p>Veio aqui pra conhecer a última moda em bijouterias e acessórios?<br>
                 Sinta-se em casa! Na página  você vai encontrar todas as bijuterias da moda.</p>
              <a class="btn" href="#" style="background-color: black;" >Produtos</a> </div>
            <div class="col-md-5 col-12 order-md-2 order-1"><img src="{{asset('assets/img/img-3.png')}}" class="mx-auto" alt="slide"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev bg-light" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
  <a class="carousel-control-next bg-light" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
</div> 

<div class="container">
  @if(request()->is('/')) 
    <h3 class="text-center text-uppercase mt-5">Últimos lançamentos</h3>
  @endif





  <div class="front row mt-4">
    @if(count($produtos)>=1)
    @foreach ($produtos as $key => $produto )
      <div class="col-md-4 h-25" style="max-height: 600px;">
        <div class="card col-10" style="max-height: 600px; height: 550px;">
          @if($produto->fotos->count())
            <img src="{{asset('storage/'.$produto->fotos->first()->path) }}" class="card-img-top" alt="..." style="max-height: 300px;height: 250px;">
          @else
            <img src="{{asset('storage/produtos/semfoto.png') }}" class="card-img-top" alt="..." style="height: 250px;">
          @endif
          <div class="card-body">
            <h4 class="card-title" style="font-size: 20px;">{{ $produto->nome }}</h4>
            <hr>
            <p calss="card-text" style="font-size: 12px;">
              {{$ctrlHome->reduzirDescricao($produto->descricao)}}
            </p>
            <h3 class="">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h3>
            <a href="{{route('produto', ['slug'=>$produto->slug]) }}" class="btn bg-light">Ver produto</a>

            @if($produto->favoritos()->count())
            @if(request()->is('favoritos'))
            <i class="fas fa-crown"></i>
            <form action="{{ route('cliente.removerFavorito', ['id'=>$produto->id]) }}" method="POST">
              @method('delete')
              @csrf
              <button type="submit" class="btn btn-danger ml-5 btn-sm">Remover dos meus favoritos</button>
            </form>
            @endif
            @endif

          </div>
        </div>
      </div>
      @if(($key + 1) % 3 == 0) </div> <div class="row mt-3"> @endif
    @endforeach
    </div>
    @else
    <div class="col-12">
    <div class="row">
      <div class="col-5">
      </div>
    <h3 class="text-center" align="center">Nenhum resultado</h3>
    <div class="col-5">
    </div>
  </div>
</div>
    @endif

</div>
@if(count($produtos)>=1)
<div class="text-center hoverable p-4">
  <div class="row">
    <div class="col-md-4 offset-md-1 mx-3 my-3">
      <div class="view overlay">
        @if($produto->fotos->count())
          <img src="{{asset('storage/'.$produto->fotos->first()->path) }}" alt="" class="img-fluid">
        @else
          <img src="{{asset('storage/produtos/semfoto.png') }}" alt="" class="img-fluid">
        @endif
        <a>
          <div class="mask rgba-white-slight"></div>
        </a>
      </div>
    </div>
    <div class="col-md-7 text-md-left ml-3 mt-3">
      <h5 class="h4 mb-4 "><strong>Bijuterias</strong></h5>
      <h6 class="card-title">{{ $produto->nome }}</h6>
      <hr>
      <p class="font-weight-normal">
        Todo look ganha muito mais personalidade com bijuterias lindase estilosas. Os acessórios são uma ótima forma de tornar mais elegante ou divertido um look básico. Desde modelos básicos aos mais modernos,
        os acessórios são perfeitos para acrescentar mais estilo ao visual. 
        Na E-Biju, você também encontra versões menores ou maiores, do tipo mais delicado ou mais pesado. 
      </p>
      <p class="font-weight-normal">Data de <a><strong>lançamento</strong></a>, {{ $produto->created_at->format('d/m/Y') }}</p>
      <a href="{{route('produto', ['slug'=>$produto->slug]) }}" class="btn bg-light center">Ver produto</a>
    </div>
  </div> 
</div>
@endif
<div class="container mt-5">
  <div class="row blog">
    <div class="col-md-12">
      <h3 class="text-center text-uppercase">Destaques</h3>
      <div id="blogCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
              <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#blogCarousel" data-slide-to="1"></li>
          </ol>
          <div class="carousel-inner">
              <div class="carousel-item active">
                  <div class="row">
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-1.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-2.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-3.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-4.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                  </div>
              </div>
              <div class="carousel-item">
                  <div class="row">
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-5.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-6.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-7.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                      <div class="col-md-3">
                          <a href="#">
                            <img src="{{asset('assets/img/img-8.webp')}}" alt="Image" class="img-fluid">
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
@if(count($produtos)>=1)
<div class="text-center hoverable p-4 ">
  <div class="row">
    <div class="col-md-7 text-md-left ml-2">
      <h5 class="h4 mb-4 "><strong>Bijuterias</strong></h5>
      <h6 class="card-title">{{ $produto->nome }}</h6>
      <hr>  
        <p class="font-weight-normal">
          Aqui você vai encontrar acessórios de moda com excelentes preços e uma qualidade incrível!
          Nada melhor do poder comprar Bijuterias lindas e com um precinho de amiga para amiga!
          Procurando algo ainda mais especial? Também temos! Confira a categoria de semijoias da E-Biju.
        </p>
        <p class="font-weight-normal">Data de <a><strong>lançamento</strong></a>, 19/08/2020</p>
        <a href="{{route('produto', ['slug'=>$produto->slug]) }}" class="btn bg-light center">Ver produto</a>
    </div>
    <div class="col-md-4 offset-md-1 mx-3 my-3">
      <div class="view overlay">
        @if($produto->fotos->count())
          <img src="{{asset('storage/'.$produto->fotos->first()->path) }}" alt="" class="img-fluid">
        @else
          <img src="{{asset('storage/produtos/semfoto.png') }}" alt="" class="img-fluid">
        @endif
        <a>
          <div class="mask rgba-white-slight"></div>
        </a>
      </div>
    </div>
</div>
@endif
@if (session()->has('cliente'))
  @php
      $cliente = session()->get('cliente');    
  @endphp
  <div class="toast" style="position: absolute; top: 0; right: 0;" data-delay="4000">
    <div class="toast-header">
      <img src="{{ asset('assets/img/logo.png') }}" class="rounded mr-2" alt="..." style="width: 60px;">
      <strong class="mr-auto">E-BIJU  </strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      Olá, {{ $cliente['nome'] }}, seja bem vindo!
    </div>
  </div>
</div>
@endif
@endsection