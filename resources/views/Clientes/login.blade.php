@extends('layouts.index')
@section('content')
<div class="form col-4">
  
    <div class="alert alert-danger d-none messageBox" role="alert">
     
      </div>
<form class="mt-3" name="formLogin">
    <div class="form-group">
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="e-mail" id="email">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" name="senha" placeholder="senha">
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
  
</form>
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