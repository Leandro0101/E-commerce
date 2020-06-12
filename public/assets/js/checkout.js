<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js">
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
</script>