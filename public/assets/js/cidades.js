$('#estados').on("change", function(){
    var estado = $("#estados").val();
    $.ajax({
        type: 'GET',
        url: urlCidadesPorEstado,
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function(){
            $('.carregando').removeClass('d-none');
        },
        success: function(response){
            $('.carregando').addClass('d-none');
            document.querySelector('div.cidades').innerHTML = preencherSelect(response.cidades);
        }
        
    });
});

function preencherSelect(cidades){
    let select = '<label>Cidade</label>';
    select += '<select name="cidade" class="form-control">';
    
    cidades.forEach(function(cidade) {
        select += `<option value="${cidade.name}">${cidade.name}</option>`;
    });

    select += '</select>';

    return select;
}
