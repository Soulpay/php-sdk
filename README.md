# SoulPay
 E-Commerce API SDK

## Introdução

Este documento explica como realizar a integração com a API de E-Commerce
utilizando nosso **SDK em PHP** para começar a realizar transações.

## Requerimentos

- PHP 7.0+

## Instalação com Composer

```BASH

composer require soulpay/soulpay-sdk

```

## Vamos Começar

Para utilizar este SDK
 recomenda-se leitura da [documentação](https://doc-api.portalsoulpay.com.br/docs/howTo.html)
 
 A API é capaz de realizar transações de **cartão de crédito**, geração de **boletos** e **recorrências** diárias, semanais, mensais ou outras escolhas de período.
 
## Ambientes

 Para utilizar este SDK em ambiente de teste é necessario colocar o ultimo parametro do construtor de uma request como false, como demonstrado abaixo.
 
 ```PHP
 // Request para o ambiente de desenvolvimento
 $request = new CreditCardRequest('Sua chave JWT aqui', false);
 
 // Request para o ambiente de produção
 $request = new CreditCardRequest('Sua chave JWT aqui', true);
 ```

## Realizar Login

Para realizar o login é necessário criar um objeto **Login**, preenche-lo com **Email** e **Password**. 
Logo após, é necessário instanciar a classe **LoginRequest** e passar o objeto **Login** (previamente criado) ao método **send**.

### Vejamos um exemplo abaixo

```PHP

$login = new Login();

$login->setEmail('testedev@dev.com');
$login->setPassword('testeDev');

$loginRequest = new LoginRequest(false);

$response = $loginRequest->send(json_encode($login));

```

## Refresh Token

Para que não seja necessário fazer login sempre que seu token JWT expirar, criamos o método **refreshToken** para facilitação do processo.

Para realizar a atualização de seu token é necessário criar um objeto **Token** e preenche-lo com seu refreshToken.
Logo após, é necessário instanciar a classe **tokenRequest** passando seu token JWT e em seguida passar o objeto **token** (previamente criado) ao método **send**.

```PHP
    $token = new Token();

    // Utilizar o refresh token para gerar um novo token
    $token->setRefreshToken('Seu refresh token');

    // Passar o token JWT aqui.
    $tokenRequest = new TokenRequest('Seu token JWT', false);

   $response = $tokenRequest->send(json_encode($token));
```

## Gerar Novo Refresh Token

Se por algum motivo for necessário gerar um novo **Refresh Token** essa função está disponivel na API. Para um novo refresh token é necessário passar como parâmetro o antigo **Refresh Token** e o **Token JWT** valido.

```PHP

 $refreshToken = new RefreshToken();
 
    // Utilizar o refresh token para gerar um novo token
    $refreshToken->setRefreshToken('39b847f1a7f626ee70e39d3529ce790e6QVAo/IFaFIXmwU4APyTRms3zE/JqpU04qRgZUoyHbSBdtsDJGH1fCeahkDUouSS');

    // Passar o token JWT aqui.
    $refreshTokenRequest = new RefreshTokenRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsImlhdCI6MTU3NjI1NjQ1MywiZXhwIjoxNTc4ODQ4NDUzfQ.9HksjlwcvMZamTKaWapylh2aHdxFXFrHYUaa0PRmGis');

    $response = $refreshTokenRequest->send(json_encode($refreshToken));

```

## Criando uma Transação

Para criar uma transação é necessário preencher as informações obrigatórias descritas na [documentação](https://doc-api.portalsoulpay.com.br/docs/howTo.html).

Seguindo a mesma ideia de login, é necessário instanciar os models da transação, sendo esses **Customer**, **Billing**, **Shipping**, **CreditCard**, **CreditInstallment**, **Payment**, **CreditCardTransaction**.  
Para enviar a transação é necessário instanciar **CreditCardTransaction** onde o token JWT deve ser passado como parâmetro.

``` PHP
$customer = new Customer();

$customer->setId('1');
$customer->setName('cliente');
$customer->setEmail('cliente@cliente.com');
$customer->setDob('1997-10-03');
$customer->setIpAddress('192.168.10.15');
$customer->setTaxId('1234134141');
$customer->setPhone1('551112345678');
$customer->setPhone2('551112345678');
$customer->setCreatedAt('2019-11-25');
$customer->setNew(false);
$customer->setVip(true);
$customer->setVisitor('gerado pelo JS');

$billing = new Billing();

$billing->setName('Soulpay');
$billing->setAddress('Avenida Paulista');
$billing->setAddress2('124');
$billing->setDistrict('Bela vista');
$billing->setCity('São Paulo');
$billing->setState('SP');
$billing->setPostalCode('01311000');
$billing->setCountry('BR');
$billing->setPhone('111112222233333');
$billing->setEmail('billing@soulpay.com.br');

$shipping = new Shipping();

$shipping->setName('Soulpay');
$shipping->setAddress('Avenida Paulista');
$shipping->setAddress2('124');
$shipping->setDistrict('Bela vista');
$shipping->setCity('São Paulo');
$shipping->setState('SP');
$shipping->setPostalCode('01311000');
$shipping->setCountry('BR');
$shipping->setPhone('12345678');
$shipping->setEmail('shipping@soulpay.com.br');

$creditCard = new CreditCard();

$creditCard->setCardHolderName('Soulpay');
$creditCard->setNumber('4620685100802685');
$creditCard->setExpDate('12/2022');
$creditCard->setCvvNumber('420');

$creditInstallment = new CreditInstallment();

$creditInstallment->setNumberOfInstallments(1);
$creditInstallment->setChargeInterest('N');

$payment = new Payment();

$payment->setChargeTotal(10.5);
$payment->setCurrencyCode('BRL');
$payment->setCreditInstallment($creditInstallment);

$creditCardTransaction = new CreditCardTransaction();

$creditCardTransaction->setReferenceNum('123456');
$creditCardTransaction->setCustomer($customer);
$creditCardTransaction->setBilling($billing);
$creditCardTransaction->setShipping($shipping);
$creditCardTransaction->setCreditCard($creditCard);
$creditCardTransaction->setPayment($payment);

// Passar o token JWT aqui.
$request = new CreditCardRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjEsImlhdCI6MTU3NTkwMzEyOSwiZXhwIjoxNTc4NDk1MTI5fQ.c0g6ynTtZHFSU3qh4bJWy-jea0VnKE4hGBTAs_uhNjY', false);

$response = $request->send(json_encode($creditCardTransaction)

```

## Criando uma Recorrência

Para criar uma recorrência é necessário preencher as informações obrigatórias descritas na [documentação](https://doc-api.portalsoulpay.com.br/docs/howTo.html).

Seguindo a mesma ideia de transação, é necessário instanciar os models da recorrência, sendo esses **Customer**, **Billing**, **Shipping**, **CreditCard**, **Recurring**, **CreditInstallment**, **Payment**, **RecurringTransaction**. Para enviar a recorrência é necessário instanciar **RecurringRequest** onde o token JWT deve ser passado como parâmetro.


``` PHP

$customer = new Customer();

$customer->setId('1');
$customer->setName('cliente');
$customer->setEmail('cliente@cliente.com');
$customer->setDob('1997-10-03');
$customer->setIpAddress('192.168.10.15');
$customer->setTaxId('1234134141');
$customer->setPhone1('551112345678');
$customer->setPhone2('551112345678');
$customer->setCreatedAt('2019-11-25');
$customer->setNew(false);
$customer->setVip(true);
$customer->setVisitor('gerado pelo JS');

$billing = new Billing();

$billing->setName('Soulpay');
$billing->setAddress('Avenida Paulista');
$billing->setAddress2('124');
$billing->setDistrict('Bela vista');
$billing->setCity('São Paulo');
$billing->setState('SP');
$billing->setPostalCode('01311000');
$billing->setCountry('BR');
$billing->setPhone('111112222233333');
$billing->setEmail('billing@soulpay.com.br');

$shipping = new Shipping();

$shipping->setName('Soulpay');
$shipping->setAddress('Avenida Paulista');
$shipping->setAddress2('124');
$shipping->setDistrict('Bela vista');
$shipping->setCity('São Paulo');
$shipping->setState('SP');
$shipping->setPostalCode('01311000');
$shipping->setCountry('BR');
$shipping->setPhone('12345678');
$shipping->setEmail('shipping@soulpay.com.br');

$creditCard = new CreditCard();

$creditCard->setCardHolderName('Soulpay');
$creditCard->setNumber('4620685100802685');
$creditCard->setExpDate('12/2022');
$creditCard->setCvvNumber('420');

$creditInstallment = new CreditInstallment();
$creditInstallment->setNumberOfInstallments(1);
$creditInstallment->setChargeInterest('N');

$payment = new Payment();

$payment->setChargeTotal(10.5);
$payment->setCurrencyCode('BRL');
$payment->setCreditInstallment($creditInstallment);

$recurring = new Recurring();

$recurring->setStartDate('2022-01-10');
$recurring->setPeriod('monthly');
$recurring->setFrequency('1');
$recurring->setInstallments('12');
$recurring->setFirstAmount(20.2);
$recurring->setFailureThreshold(15);

$recurringTransaction = new RecurringTransaction();

$recurringTransaction->setReferenceNum('123456');
$recurringTransaction->setCustomer($customer);
$recurringTransaction->setBilling($billing);
$recurringTransaction->setShipping($shipping);
$recurringTransaction->setCreditCard($creditCard);
$recurringTransaction->setPayment($payment);
$recurringTransaction->setRecurring($recurring);

// Passar o token JWT aqui.
$request = new RecurringRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjEsImlhdCI6MTU3NTkwMzEyOSwiZXhwIjoxNTc4NDk1MTI5fQ.c0g6ynTtZHFSU3qh4bJWy-jea0VnKE4hGBTAs_uhNjY', false);

$response = $request->send(json_encode($recurringTransaction))

```

## Ativando/desativando uma Recorrência

Na edição de recorrência é necessário instanciar a model **RecurringStatus**. Para enviar a requisição é necessário instanciar **RecurringRequest**, onde o token JWT deve ser passado como parâmetro.


``` PHP

$recurringStatus = new RecurringStatus();

//Passar a ação a ser executada: disable | enable
$recurringStatus->setStatus('disable');

// Passar o token JWT aqui.
$request = new RecurringRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsImlhdCI6MTU3NjA3Mzc0MiwiZXhwIjoxNTc4NjY1NzQyfQ.45tr4BlNhzRQQc1nLw9C6kUqMpwS1WxdYptSIBmHtE4', false);

// Order ID
$response = $request->put(10407, json_encode($recurringStatus));

```

## Gerando Boleto Bancario

Para criar um boleto é necessário preencher as informações obrigatorias descritas na [documentação](https://doc-api.portalsoulpay.com.br/docs/howTo.html).

Seguindo a mesma ideia de transação é necessário instanciar os models de boleto, sendo esses **Customer**, **Billing**, **BankSlip**, **Payment**, **BankSLipTransaction**, **BankSlipRequest**.  
Para enviar o boleto bancario é necessário instanciar **BankSlipTransaction** onde o token JWT deve ser passado como parâmetro.

```PHP

    $billing = new Billing();
    
    $billing->setName('SoulPay');
    $billing->setAddress('Avenida Paulista');
    $billing->setAddress2('124');
    $billing->setDistrict('Bela vista');
    $billing->setCity('São Paulo');
    $billing->setState('SP');
    $billing->setPostalCode('01311000');
    $billing->setCountry('BR');
    $billing->setPhone('111112222233333');
    $billing->setEmail('billing@soulpay.com.br');

    $customer = new Customer();

    $customer->setName('Cliente');
    $customer->setTaxId('12234554323');

    $bankSlip = new BankSlip();

    $bankSlip->setExpirationDate('2022-12-25');
    $bankSlip->setInstructions('teste API');

    $payment = new Payment();
    
    $payment->setChargeTotal(10.5);
    $payment->setCurrencyCode('BRL');

    $bankSlipTransaction = new BankSlipTransaction();

    $bankSlipTransaction->setReferenceNum('123456');
    $bankSlipTransaction->setCustomer($customer);
    $bankSlipTransaction->setBilling($billing);
    $bankSlipTransaction->setBankSlip($bankSlip);
    $bankSlipTransaction->setPayment($payment);


  // Passar o token JWT aqui.
    $bankSlipRequest = new BankSlipRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsImlhdCI6MTU3NjA3Mzc0MiwiZXhwIjoxNTc4NjY1NzQyfQ.45tr4BlNhzRQQc1nLw9C6kUqMpwS1WxdYptSIBmHtE4', false);
    
$response = $bankSlipRequest->send(json_encode($bankSlipTransaction))
    
```

## Consulta de transações

Para consultar uma transação, é necessário instanciar a classe **CreditCardRequest**. O **Order ID** deve ser passado como parâmetro de busca.

```PHP

// Passar o token JWT aqui.
$request = new CreditCardRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjEsImlhdCI6MTU3NTkwMzEyOSwiZXhwIjoxNTc4NDk1MTI5fQ.c0g6ynTtZHFSU3qh4bJWy-jea0VnKE4hGBTAs_uhNjY', false);

// Order ID
$response = $request->get(253);

```

## Consulta de boletos

Para consultar um boleto, é necessário instanciar a classe **BankSlipRequest**. O **Order ID** deve ser passado como parâmetro de busca.

```PHP

// Passar o token JWT aqui.
$request = new BankSlipRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsImlhdCI6MTU3NjA3Mzc0MiwiZXhwIjoxNTc4NjY1NzQyfQ.45tr4BlNhzRQQc1nLw9C6kUqMpwS1WxdYptSIBmHtE4', false);

// Order ID
$response = $request->get(253);

```

## Consulta de recorrências

Para consultar uma recorrência, é necessário instanciar a classe **RecurringRequest**. O **Order ID** deve ser passado como parâmetro de busca.

```PHP

// Passar o token JWT aqui.
$request = new RecurringRequest('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsImlhdCI6MTU3NjA3Mzc0MiwiZXhwIjoxNTc4NjY1NzQyfQ.45tr4BlNhzRQQc1nLw9C6kUqMpwS1WxdYptSIBmHtE4', false);

// Order ID
$response = $request->get(253);

```

## Suporte

[Utilizar o issues do github](https://github.com/Soulpay/php-sdk/issues)
