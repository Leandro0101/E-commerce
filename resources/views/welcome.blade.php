@extends('layouts.index')
@section('content')
<div class="row mt-3">
  @foreach ($produtos as $key => $produto )
<div class="col">
  <div class="card" style="width: 15rem;">
    @if($produto->fotos->count())
    
    <img src="{{ asset('storage/'.$produto->fotos->first()->path) }}" class="card-img-top" alt="...">

    @else

    <img src="{{ asset('storage/produtos/semfoto.png') }}" class="card-img-top" alt="...">

    @endif

    <div class="card-body">
      <h5 class="card-title display-4" align="center" style="font-size: 15px;">{{ $produto->nome }}</h5>
      <hr>
      <h5 class="" align="center">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h5>
      <a href="{{ route('produto', ['slug'=>$produto->slug]) }}" class="btn btn-success ml-5 btn-sm">Ver produto</a>
    </div>
  </div>
</div>
@if(($key+1)%4 == 0)
</div> <div class="row mt-3">
@endif
  @endforeach
</div>
@endsection
