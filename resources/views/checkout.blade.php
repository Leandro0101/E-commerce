@extends('layouts.index')
@section('stylesheet')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="container mt-5">
    <div class="alert alert-danger d-none messageBox" role="alert"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h5>Dados para pagamento</h5>
                    <hr class="">
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nome no cartão</label>
                        <input type="text" class="form-control" name="card_name"
                            value="{{ session()->get('cliente')->nome }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>CPF - Titular</label>
                        <input type="text" class="form-control" name="cpf" id="cpf"
                            value="{{ session()->get('cliente')->cpf }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Número do cartão</label>
                        <span class="brand"></span>
                        <input type="text" class="form-control" name="card_number" id="card_number">
                        <input type="hidden" name="card_brand">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Nascimento - Titular</label>
                        <input type="text" class="form-control" name="nascimento" id="nascimento">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Mês de expiração</label>
                        <input type="text" class="form-control" name="card_month" placeholder="ex: 05" id="mes">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Ano de expiração</label>
                        <input type="text" class="form-control" name="card_year" placeholder="ex: 2050" id="ano">
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label for="">Telefone</label>
                        <input type="text" class="form-control" name="ddd" id="ddd" placeholder="DDD">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Telefone</label>
                        <input type="text" class="form-control" name="telefone" id="telefone" placeholder="número">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Código de segurança</label>
                        <input type="text" class="form-control" name="card_cvv" id="cvv">
                    </div>
                    <div class="col-md-8 form-group installments"></div>
                </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h5>Dados - Endereço da entrega</h5>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label>Estado</label>
                    {{-- Select puxa todos os estados do banco de dados --}}
                    <select name="estado" id="estados" class="form-control">
                        <option></option>
                        @foreach ($states as $state)
                        <option name="" value="{{ $state->abbreviation }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group">
                    <div class="cidades">
                        <div class="alert alert-info d-none carregando" role="alert">
                            Carregando...
                        </div>
                    </div>
                </div>

                <div class="col-md-4 form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" class="form-control"
                        @if(isset(session()->get('cliente')->endereco()->first()->bairro))
                    value="{{ session()->get('cliente')->endereco()->first()->bairro }} @endif">
                </div>

            </div>

            <div class="row">
                <div class="col-md-7 form-group">
                    <label>Endereço</label>
                    <input type="text" class="form-control" name="endereco"
                        @if(isset(session()->get('cliente')->endereco()->first()->endereco))value="{{ session()->get('cliente')->endereco()->first()->endereco }}
                    @endif">
                </div>

                <div class="col-md-4 form-group">
                    <label>Número</label>
                    <input type="text" class="form-control" name="numero" id="numero"
                        @if(isset(session()->get('cliente')->endereco()->first()->numero))
                    value="{{ session()->get('cliente')->endereco()->first()->numero }} @endif">
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 form-group">
                    <label>Complemento</label>
                    <input type="text" class="form-control" name="complemento"
                        @if(isset(session()->get('cliente')->endereco()->first()->complemento))value="{{ session()->get('cliente')->endereco()->first()->complemento }}
                    @endif">
                </div>
                <div class="col-md-4 form-group">
                    <label>CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep"
                        @if(isset(session()->get('cliente')->endereco()->first()->cep))value="{{ session()->get('cliente')->endereco()->first()->cep }}"
                    @endif>
                </div>
            </div>

            <div class="row">
                <button class="btn btn-success btn-ms processCheckout mt-4 ml-3">Efetuar pagamento</button>
                <strong class="processando d-none">
                    Processando...
                </strong>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>


<script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
<script>
    const sessionId = '{{session()->get('pagseguro_session_code')}}';
    PagSeguroDirectPayment.setSessionId(sessionId);
    const urlCidadesPorEstado = '{{route("checkout.cidadesPorEstados")}}';
</script>
<script src="{{ asset('assets/js/mascaras.js') }}"></script>
<script src="{{ asset('assets/js/cidades.js') }}"></script>

<script>
    let amountTransaction = '{{$cartItems}}';
    let cardNumber = document.querySelector('input[name=card_number]');
    let spanBrand = document.querySelector('span.brand');
    cardNumber.addEventListener('keyup', function () {
        if (cardNumber.value.length >= 6) {
            PagSeguroDirectPayment.getBrand({
                cardBin: cardNumber.value.substr(0, 6),
                success: function (res) {
                    let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                    spanBrand.innerHTML = imgFlag;
                    document.querySelector('input[name=card_brand]').value = res.brand.name;
                    getInstallments(amountTransaction, res.brand.name);

                },
                error: function (err) {
                    console.log(err);
                },
                complete: function (res) {
                    console.log('complete: ', res);
                }
            });
        }
    });

    let submitButton = document.querySelector('button.processCheckout');

    submitButton.addEventListener('click', function (event) {

        event.preventDefault();

        PagSeguroDirectPayment.createCardToken({
            cardNumber: document.querySelector('input[name=card_number]').value,
            brand: document.querySelector('input[name=card_brand]').value,
            cvv: document.querySelector('input[name=card_cvv]').value,
            expirationMonth: document.querySelector('input[name=card_month]').value,
            expirationYear: document.querySelector('input[name=card_year]').value,
            success: function (res) {
                console.log(res);
                processPayment(res.card.token)
            },
            error: function (err) {
                $('.processando').addClass('d-none');
                $('.processCheckout').removeClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'E-BIJU',
                    text: 'Tivemos um problema no processamento do pagamento, verifique se todos seus dados conferem!',
                })

            }
        });
    });



    function processPayment(token) {
        $('.processCheckout').addClass('d-none');
        $('.processando').removeClass('d-none');

        let data = {
            card_token: token,
            hash: PagSeguroDirectPayment.getSenderHash(),
            installment: document.querySelector('select.select_installments').value,
            estado: document.querySelector('select[name=estado]').value,
            cidade: document.querySelector('select[name=cidade]').value,
            bairro: document.querySelector('input[name=bairro]').value,
            numero: document.querySelector('input[name=numero]').value,
            complemento: document.querySelector('input[name=complemento]').value,
            endereco: document.querySelector('input[name=endereco]').value,
            cpf: document.querySelector('input[name=cpf]').value,
            cep: document.querySelector('input[name=cep]').value,
            telefone: document.querySelector('input[name=telefone]').value,
            ddd: document.querySelector('input[name=ddd]').value,
            nascimento: document.querySelector('input[name=nascimento]').value,
            card_name: document.querySelector('input[name=card_name]').value,
            _token: '{{csrf_token()}}'
        };

        $.ajax({
            type: 'POST',
            url: '{{route("checkout.proccess")}}',
            data: data,
            dataType: 'json',
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'E-BIJU',
                    text: 'Compra efetuado com sucesso!',
                })

                window.location.href = "{{ route('home') }}";
            },
            complete: function (res) {

            },
            error: function (err) {
                $('.processCheckout').removeClass('d-none');
                $('.processando').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'E-BIJU',
                    text: 'Tivemos um problema no processamento do pagamento, verifique se todos seus dados conferem!',
                })

            }
        });
    }


    function getInstallments(amount, brand) {
        PagSeguroDirectPayment.getInstallments({
            amount: amount,
            brand: brand,
            maxInstallmentNoInterest: 0,
            success: function (res) {
                let selectInstallments = drawSelectInstallments(res.installments[brand]);
                document.querySelector('div.installments').innerHTML = selectInstallments;
            },
            error: function (err) {
                console.log(err);
            },
            complete: function (res) {

            },
        })
    }

    function drawSelectInstallments(installments) {
        let select = '<label>Opções de Parcelamento:</label>';

        select += '<select class="form-control select_installments col">';

        for (let l of installments) {
            select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
        }


        select += '</select>';

        return select;
    }

</script>
@endsection