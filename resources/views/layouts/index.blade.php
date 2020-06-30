<?php 
use App\ClienteFoto;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.css')}}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4b5357eb64.js" crossorigin="anonymous"></script>
    {{-- Script dos sweetAlerts --}}
    <script src="{{ asset('assets/js/sweetAlert.js') }}"></script>
     
    <!-- Css Stylesheet -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}">
    @yield('stylesheet')

</head>
  <body>
    {{-- Testando se o cliente está autenticado, se estiver a variável cliente vai receber seus dados --}}
    @if(session()->has('cliente'))
      @php 
        $cliente = session()->get('cliente');
      @endphp
    @endif
    <nav id="navbar_top" class="navbar navbar-expand-md navbar-light bg-light">
      <div class="container-fluid">
        {{-- Essa rota volta para essa mesma página --}}
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="" id="logo-brand"></a>
        <div class="collapse navbar-collapse" id="main_nav">
          <div class="offcanvas-header mt-3">  
            <h5 class="py-2 bg-light">E-Biju</h5>
          </div>
          <ul class="navbar-nav ml-5">
            <li class="nav-item dropdown has-megamenu">
              <a class="nav-link dropdown-toggle ml-5 float-right" data-toggle="dropdown" style="cursor: pointer;">Setores</a>
              <div class="dropdown-menu megamenu col-3">
                <h6 class="dropdown-item" ><strong> Nossas Categorias</strong></h6>

                {{-- Só vai exibir essa parte se houver categorias--}}
                @if (isset($categorias))
                {{-- Foreach vai puxar e exibir todas as categorias do banco --}}
                  @foreach ($categorias as $categoria)
                  {{-- Se a categoria estiver sem produtos, ela não será exibida --}}
                    @if($categoria->produtos()->count())
                      <a class="dropdown-item"  href="{{ route('exibirPorCategoria', ['categoria' => $categoria->id]) }}">{{ $categoria->nome }}</a>
                    @else
                    @endif
                  @endforeach
                @endif

                <h6 ><strong><a class="ml-4" style="text-decoration: none;color:black;" href="{{ route('mais_vendidos') }}">Mais vendidos</a></strong></h6>
                <h6 ><strong><a class="ml-4" style="text-decoration: none;color:black;" href="{{ route('home') }}">Lançamentos</a></strong></h6>
              </div>
            </li>

            <div class="container h-100">
              <form action="{{ route('busca') }}" class="form-inline my-2 my-lg-0" method="GET">
                <div class="d-flex justify-content-center h-100">
                  <div class="hem-barra-busqueda" style="margin-top:2px">
                    <input class="hem-search-input" autocomplete="off" type="text" name="pesquisa_produt" placeholder="Algo em específico? Procure aqui...." >
                    <button class="btn hem-search-icon" type="submit"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </ul>
          
          <div class="mr-auto"></div>

          @guest
            <ul class="navbar-nav">
              {{-- Se não existe a sessão cliente, ou seja, se o cliente não está logado, irá aparecer as opções para ir para a view de criar uma conta ou fazer o login --}}
              @if(!session()->get('cliente'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('cliente.criar') }}"><i class="fas fa-user-plus"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('cliente.login') }}"><i class="fas fa-sign-in-alt"></i></a>
                </li>
              {{-- Se houver a sessão, ou seja, se o cliente estiver logado, irá aparecer a sua foto de perfil (se ele tiver colocado,
                visto que é opcional), também irá aparecer suas configurações e a opção de sair  --}}
              @else
                <div class="container">
                  <div class="dropdown">
                    @if(isset($cliente->foto()->first()->path))                    
                      <a class="nav-link dropdown-toggle" href="" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20"><img src="{{ asset('storage/'.$cliente->foto()->first()->path) }}" alt="..." width="30px" style="border-radius: 20%;max-width:30px;max-height: 40px"></a>
                    @else
                      <a class="nav-link" href="" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20"><i class="fas fa-user fa-2x "></i></a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuOffset">
                      <a class="dropdown-item" href="{{ route('favoritos') }}"><i class="fas fa-users-cog">Favoritos</i></a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_config"><i class="fas fa-user-cog"> <span>Configurações</span> </i></a>
                      <a class="dropdown-item" href="{{ route('cliente.sair') }}"><i class="fas fa-door-open"> <span>Sair</span></i></a>
                    </div>
                  </div>
                </div>
              @endif
            </ul>
          @endguest

          {{-- Se houver a sessão do carrinho, ou seja, houver algum item no carrinho, o contador de itens irá incrementar a quantidade de itens no carrinho --}}
            @if(session()->has('carrinho'))
              <a class="nav-link" href="{{ route('carrinho.carrinho') }}"><i class="fas fa-shopping-bag"></i>
                {{-- Esse código soma o todos os valores da coluna quantidade --}}
                <span class="badge badge-danger">{{ array_sum(array_column(session('carrinho'), 'quantidade')) }}</span>
              </a>
            @endif
        </div>
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
                        <li class="list-group"><a class="btn  bg-light mt-4" href="{{ route('admin.produto.index') }}">Produtos</a></li>
                        <li class="list-group"><a class="btn bg-light mt-4 ml-2" href="{{ route('admin.categoria.index') }}">Categorias</a></li>
                        <li class="list-group"><a class="btn bg-light mt-4 ml-2" href="{{ route('home') }}">Menu-Admin</a></li>
                      </ul>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                      <ul class="list-group list-group-horizontal-lg">  
                        <li class="list-group-item mt-4">{{ auth()->user()->name}}</li>
                        <li class="list-group-item mt-4">{{ auth()->user()->email}} </li>
                        <li class="list-group-item mt-4"><a class="btn btn-outline-danger btn-sm" href="" onclick="event.preventDefault(); document.querySelector('form.logout').submit();">Sair</a>
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
              <h5 class="modal-title" id="exampleModalLabel"><li class="fas fa-user-shield"> <span>Minha Conta</span></i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Nome</label>
                  {{-- pega o nome do cliente autenticado --}}
                  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="{{ $cliente['nome'] }}" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Endereço de e-mail</label>
                  {{-- pega o email do cliente autenticado --}}
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ $cliente['email'] }}" readonly>
                </div>
                {{-- link para a rota dos dados de endereço do cliente autenticado --}}
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marked-alt"></i><a href="{{ route('endereco.edit', ['endereco' => session()->get('cliente')] ) }}" style="color: black;text-decoration: none"> Meu endereço</a></i></h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
              {{-- Rota de auteração dos dados do cliente --}}
              <a href="{{ route('cliente.edit', ['id' => $cliente['id']]) }}" class="btn btn-warning">Alterar</a>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Incluindo as messaggens flash --}}
    @include('flash::message')
    <div class="">
      @yield('content')
    </div>
    <footer class="mt-5">
      <div class="bg-light">
        <div class="container">
          <div class="row py-4 d-flex align-items-center">
            <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
              <h6 class="mb-0">A moda sai de moda, o estilo jamais.</h6>
            </div>
            <div class="col-md-6 col-lg-7 text-center text-md-right">
              <a class="fb-ic">
                <i class="fab fa-facebook-f white-text mr-4"> </i>
              </a>
              <a class="tw-ic">
                <i class="fab fa-twitter white-text mr-4"> </i>
              </a>
              <a class="gplus-ic">
                <i class="fab fa-google-plus-g white-text mr-4"> </i>
              </a>
              <a class="li-ic">
                <i class="fab fa-linkedin-in white-text mr-4"> </i>
              </a>
              <a class="ins-ic">
                <i class="fab fa-instagram white-text"> </i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="container text-center text-md-left mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase font-weight-bold">Saiba Mais</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet,
              consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur.</p>
          </div>
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase font-weight-bold">Links Úteis</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
              <a href="https://jus.com.br/artigos/71903/feminicidio-e-a-omissao-do-estado">Feminicídio</a>
            </p>
            <p>
              <a href="https://transformese.com.br/antirracismo/">Antirracismo</a>
            </p>
            <p>
              <a href="https://www.pensamentoverde.com.br/atitude/10-dicas-de-sustentabilidade-ambiental/">Sustentabilidade</a>
            </p>
            <p>
              <a href="http://portal.anvisa.gov.br/noticias?p_p_id=101_INSTANCE_FXrpx9qY7FbU&p_p_col_id=column-2&p_p_col_count=2&_101_INSTANCE_FXrpx9qY7FbU_groupId=219201&_101_INSTANCE_FXrpx9qY7FbU_urlTitle=instituicoes-de-acolhimento-acoes-contra-a-covid-19&_101_INSTANCE_FXrpx9qY7FbU_struts_action=%2Fasset_publisher%2Fview_content&_101_INSTANCE_FXrpx9qY7FbU_type=content">
              Ações Covd-19</a>
            </p>
          </div>
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase font-weight-bold">Contato</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block" style="width: 60px;">
            <p>
              <i class="fas fa-map-marked-alt mr-2"></i>Ceará, CE 10012, BR
            </p>
            <p>
              <i class="fas fa-envelope mr-2"></i> e.biju@gamil.com
            </p>
            <p>
              <i class="fas fa-headset mr-2"></i> 01 234 567 88
            </p>
          </div>
      <div class="col-md-3 col-xl-4 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold">Produtos Recentes</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block" style="width: 60px;">
        <div class="row">

        </div>
      </div>
        </div>
      </div>
      <div class="footer-copyright text-center py-3">© 2020 Copyright:
        <a href="#"> E-Biju</a>
      </div>
    </footer>
    {{-- bootstrap e suas dependências --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    {{-- ajax --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('assets/js/jqueryHome.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.js')}}"></script>
    @yield('scripts')
  </body>
</html>