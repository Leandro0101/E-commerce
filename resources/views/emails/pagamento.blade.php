
<img src="https://static.vecteezy.com/system/resources/previews/000/577/234/non_2x/golden-glittery-confetti-on-white-background-vector.jpg" class="img-fluid" width="300px">
<h1>Obrigado pela compra em nossa loja, {{ session()->get('cliente')->nome }}!</h1>
<hr>
<p>Sua mercadoria chegará em breve nesse endereço!;)</p>
<p>Estado: {{ session()->get('cliente')->endereco()->estado }}</p>
<p>Cidade: {{ session()->get('cliente')->endereco()->cidade }}</p>
<p>bairro: {{ session()->get('cliente')->endereco()->bairro }}</p>
<p>Numero: {{ session()->get('cliente')->endereco()->numero }}</p>
<p>Endereco: {{ session()->get('cliente')->endereco()->endereco }}</p>
<p>Cep: {{ session()->get('cliente')->endereco()->cep }}</p>

<hr>

Email enviado em {{date('d/M/Y H:i:s')}}.