@extends('layouts.index')
@section('content')
  <div class="form">
    <div class="alert alert-danger d-none messageBox" role="alert">
  </div>
  <div class="container">
      <div class="row pt-5 mt-3 justify-content-center align-items-center">
          <div class="col-md-8">
              <div class="card">
                <div class="card-body">
                  <form id="login-form" class="form-group p-3" name="formLogin" action="" method="post">
                      <h3 class="card-header text-center text-dark">Login</h3>
                      <div class="form-group mt-3">
                          <label for="email" class="text-dark">Email:</label><br>
                          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail" id="email">
                      </div>
                      <div class="form-group">
                          <label for="password" class="text-dark">Senha:</label><br>
                          <input type="password" name="senha" id="password" class="form-control" placeholder="Senha">
                      </div>
                      <div class="form-group">
                          <label for="remember-me" class="text-dark"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                          <input type="submit" name="submit" class="btn bg-light btn-md" value="Entrar">
                      </div>
                      <div id="register-link" class="text-right">
                          <a href="#" class="text-dark">Register here</a>
                      </div>
                  </form>
                </div>  
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
  <script>
    $(function(){
      $('form[name="formLogin"]').submit(function(event){
        event.preventDefault();
        $.ajax({
          type: 'GET',
          url: '{{route("cliente.autenticacao")}}',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.success === true){
              window.location.href = "{{ route('home') }}";
            }else{
              $('.messageBox').removeClass('d-none').html(response.message);
            }
          }
        });
      });
    });
  </script>
@endsection 