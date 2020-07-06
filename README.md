# 🎥Pré-visualização
 <h1>
    <img align="center" src="https://ik.imagekit.io/leandro0101/inicial_1Viduxp1I.png" width="650px">
    <img align="center" src="https://ik.imagekit.io/leandro0101/single_produto_NGWH63PYn.png" width="650px">
    <img align="center" src="https://ik.imagekit.io/leandro0101/pagamento_aA1P5HcwJ.png" width="650px">
    <img align="center" src="https://ik.imagekit.io/leandro0101/pagamentoError__kQ1bdnYAl.png" width="650px">
</h1>

## 📝Sobre
Este e-commerce foi um projeto de conclusão de bimestre do curso técnico em Informática, cadeira de laboratório web, pela escola profissionalizante **E.E.E.P Professora Luiza de Teodoro Vieira**. Tem como principal objetivo o aprendizado de uma nova tecnologia - o **laravel**- e exercitar conhecimentos já adquiridos ao longo do ensino médio.
---
## Tecnologias utilizadas
O projeto foi desenvolvido utilizando as seguintes tecnologias

- [Ajax](https://api.jquery.com/category/ajax/)
- [Laravel](https://laravel.com/docs/7.x)
- [Bootstrap](https://getbootstrap.com/docs/4.5/getting-started/introduction/)
---
## Como baixar e utilizar o projeto
 ```bash
 #baixar respositório
 $ git clone https://github.com/Leandro0101/E-commerce.git
 #entrar no projeto
 $ cd e-commerce
 #instalar dependências do projeto
 $ composer install
 ```
 #### Copiar o .env.example como .env
 ```bash
 #gerar chave da aplicação
 $ php artisan key: generate
 ```
#### Colocar as credencias do banco de dados no .env
 ```bash
 #gerar tabelas e seus registros
$ php artisan migrate --seed
#start do servidor
$ php artisan serve
```