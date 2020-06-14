let amountTransaction = '{{$cartItems}}';
let cardNumber = document.querySelector('input[name=card_number]');
let spanBrand = document.querySelector('span.brand');
cardNumber.addEventListener('keyup', function(){
    if(cardNumber.value.length >= 6){
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0, 6),
            success: function(res){
                let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                spanBrand.innerHTML = imgFlag;
                document.querySelector('input[name=card_brand]').value = res.brand.name;
                getInstallments(amountTransaction, res.brand.name);
                
            },
            error: function(err){
                console.log(err);
            },
            complete: function(res){
                console.log('complete: ', res);
            }
        });
    }
});

let submitButton = document.querySelector('button.processCheckout');

submitButton.addEventListener('click', function(event){
  
    event.preventDefault();
    
    PagSeguroDirectPayment.createCardToken({
        cardNumber: document.querySelector('input[name=card_number]').value,
        brand:      document.querySelector('input[name=card_brand]').value,
        cvv:        document.querySelector('input[name=card_cvv]').value,
        expirationMonth: document.querySelector('input[name=card_month]').value,
        expirationYear:  document.querySelector('input[name=card_year]').value,
        success: function(res){
            console.log(res);
            processPayment(res.card.token)
        }
    });
});



function processPayment(token)
{
    let data = {
        card_token: token,
        hash: PagSeguroDirectPayment.getSenderHash(),
        installment: document.querySelector('select.select_installments').value,
        card_name: document.querySelector('input[name=card_name]').value,
        _token: '{{csrf_token()}}'
    };

    $.ajax({
        type: 'POST',
        url: '{{route("checkout.proccess")}}',
        data: data,
        dataType: 'json',
        success: function(res){
            
        },
        complete: function(res){
            toastr.success('Compra efetuado com sucesso!', 'E-BIJU agradece pela preferência!')
            window.location.href = "{{ route('home') }}";
        }
    });
}


function getInstallments(amount, brand){
    PagSeguroDirectPayment.getInstallments({
        amount: amount,
        brand: brand,
        maxInstallmentNoInterest: 0,
        success: function(res){
            let selectInstallments = drawSelectInstallments(res.installments[brand]);
            document.querySelector('div.installments').innerHTML = selectInstallments;
        },
        error: function(err){
            console.log(err);
        },
        complete: function(res){
            
        },
    })
}

function drawSelectInstallments(installments) {
let select = '<label>Opções de Parcelamento:</label>';

select += '<select class="form-control select_installments">';

for(let l of installments) {
    select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
}


select += '</select>';

return select;
}
