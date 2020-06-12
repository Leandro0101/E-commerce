$(function(){
    $('form[name="formAtualizacaoCliente').submit(function(event){
        event.preventDefault();
        $.ajax({
            type: 'PUT',
            url: '',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                alert('deu certo');
            }
        });
    });
})