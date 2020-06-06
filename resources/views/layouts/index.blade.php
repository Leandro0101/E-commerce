<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d96ecac57c.js" crossorigin="anonymous"></script>

    <title>E-BIJU - ADMIN</title>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="{{ route('home') }}">E-BIJU</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.produto.index') }}">Produtos</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.categoria.index') }}">Categorias</a>
          </li>
        </ul>
        @if(session()->has('carrinho'))
          <span class="badge badge-danger">{{ array_sum(array_column(session('carrinho'), 'quantidade')) }}</span>
        @endif 
      <a href="{{ route('carrinho.carrinho') }}"><i class="fa fa-shopping-cart fa-2x"></i></a>  
      </div>                                

    </nav>
       @auth 
          <div class="container mt-5">          
            <a class="list-group-item list-group-item-action list-group-item-secondary" id="list-profile-list"><h5><i class="far fa-user"></i> {{ auth()->user()->name }}</h5></a>
            <hr class="br-dark">
            <div class="row">
              <div class="col-7">
                <div class="card bg-white">
                  <div class="row">
                    <div class="col-4">
                      <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action list-group-item-secondary active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home"><i class="fas fa-store-alt"></i> Loja</a>
                        <a class="list-group-item list-group-item-action list-group-item-secondary" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile"><i class="fas fa-user-cog"></i> ADM</a>
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                          <ul class="list-group list-group-horizontal-lg">
                            <li class="list-group"><a class="btn btn-danger mt-4" href="{{ route('admin.produto.index') }}">Produtos</a></li>
                             <li class="list-group"><a class="btn btn-danger mt-4 ml-2" href="{{ route('admin.categoria.index') }}">Categorias</a></li>
                             <li class="list-group"><a class="btn btn-danger mt-4 ml-2" href="{{ route('home') }}">Menu-Admin</a></li>
                          </ul>
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                          <ul class="list-group list-group-horizontal-lg">  
                            <li class="list-group-item mt-4">{{ auth()->user()->name}}</li>
                            <li class="list-group-item mt-4">{{ auth()->user()->email}} </li>
                            <li class="list-group-item mt-4"><a class="btn btn-outline-success btn-sm" href="" onclick="event.preventDefault(); document.querySelector('form.logout').submit();">Sair</a>
                              <form action="{{route('logout')}}" class="logout" method="post" style="display:none;">
                                @csrf
                              </form>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>          
        @endauth

      @include('flash::message')
      <div class="container">
          @yield('content')
      </div>
  
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>