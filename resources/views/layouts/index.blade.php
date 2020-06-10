
<?php 
use App\ClienteFoto;
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d96ecac57c.js" crossorigin="anonymous"></script>

    <title>E-BIJU</title>

  </head>
  <body>
    @if(session()->has('cliente'))
      @php 
        $cliente = session()->get('cliente');
      @endphp
    @endif    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      {{-- Essa rota volta para essa mesma página --}}
      <a class="navbar-brand" href="{{ route('home') }}">E-BIJU</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
          </li>

          {{-- Se o adm existir, irá aparecer no navbar as opções para navegar pelas views de produtos e categorias --}}
          @auth
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.produto.index') }}">Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categoria.index') }}">Categorias</a>
            </li>
          @endauth
          {{-- Se não existe a sessão cliente, ou seja, se o cliente não está logado, irá aparecer as opções para ir para a view de criar uma conta ou fazer o login --}}
          @if(!session()->get('cliente'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cliente.criar') }}"><i class="fas fa-user-plus"></i>Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cliente.login') }}"><i class="fas fa-sign-in-alt"></i>Login</a>
            </li>
          {{-- Se houver a sessão, ou seja, se o cliente estiver logado, irá aparecer a sua foto de perfil (se ele tiver colocado,
            visto que é opcional), também irá aparecer suas configurações e a opção de sair  --}}
          @else
            <li class="nav-item">
              <div class="col-2">
                <a class="nav-link" href="{{ route('cliente.login') }}"><img src="{{ asset('storage/'.$cliente->foto()->first()->path) }}" alt="..." class="img-fluid" style="border-radius: 100%;"></a>
              </div>
            </li>
            <div class="d-flex">
              <div class="dropdown mr-1">
                <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                  <i class="far fa-user"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_config"><i class="fas fa-users-cog">Configurações </i></a>
                  <a class="dropdown-item" href="{{ route('cliente.sair') }}"><i class="fas fa-door-open">Sair</i></a>
                </div>
              </div>
            </div>
          @endif
        </ul>
        {{-- Se houver a sessão do carrinho, ou seja, houver algum item no carrinho, o contador de itens irá incrementar a quantidade de itens no carrinho --}}
        @if(session()->has('carrinho'))
          <span class="badge badge-danger">{{ array_sum(array_column(session('carrinho'), 'quantidade')) }}</span>
        @endif 
        <a href="{{ route('carrinho.carrinho') }}"><i class="fa fa-shopping-cart fa-2x"></i></a>  
      </div>                                

    </nav>
      
    {{-- Se o administrador estiver logado, irá aparecer também o mini-menu administrativo --}}
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

  {{-- Se houver uma sessão do cliente, ou seja, se ele estiver logado, o modal de configurações poderá ser chamado --}}
  <!-- Modal -->
    @if(session()->has('cliente'))
      <div class="modal fade" id="modal_config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-shield">Minha conta</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Endereço de e-mail</label>
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ $cliente['email'] }}" readonly>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Nome</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="{{ $cliente['nome'] }}" readonly>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <a href="{{ route('cliente.edit', ['id' => $cliente['id']]) }}" class="btn btn-primary">Alterar</a>
            </div>
          </div>
        </div>
      </div>
    @endif
    @include('flash::message')
    <div class="container">
      @yield('content')
    </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    @yield('scripts')


  
  </body>
</html>