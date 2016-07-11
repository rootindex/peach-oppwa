# Peach\Oppwa Library
## Peach Payments OPPWA php library

### Examples:

There is three ways to configure the client.

```php
$config = new \Peach\Oppwa\Configuration(
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id'
);

$client = new \Peach\Oppwa\Client($config);

```

```php
$client = new \Peach\Oppwa\Client([
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id']
);
```
```php
$client = new \Peach\Oppwa\Client(
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id'
);
```

If you wish to use the test server.

```php
    $client->setTestMode(true);
```

Getting a payment status.

```php
$paymentStatus = new \Peach\Oppwa\Payments\Status($client);
$paymentStatusResult = $paymentStatus
    ->setTransactionId('8a82944a55c5c6620155ca4667222d20')
    ->process();

var_dump(json_decode((string)$paymentStatusResult, JSON_PRETTY_PRINT));
```

Storing a card.

```php
$storeCard = new \Peach\Oppwa\Cards\Store($testClient);
$storeCardResult = $storeCard->setCardBrand(\Peach\Oppwa\Cards\Brands::MASTERCARD)
    ->setCardNumber('5454545454545454')
    ->setCardHolder('Jane Jones')
    ->setCardExpiryMonth('05')
    ->setCardExpiryYear('2018')
    ->setCardCvv('123')
    ->process();
```
Deleting a saved card.
```php
$cardDelete = new \Peach\Oppwa\Cards\Delete($testClient);
$cardDelete->setTransactionId($storeCardResult->getId());
$cardDeleteResult = $cardDelete->process();
```

Doing a full debit.
```php
$debit = new \Peach\Oppwa\Payments\Debit($testClient);
$debitResult = $debit
    ->setCardBrand(\Peach\Oppwa\Cards\Brands::MASTERCARD)
    ->setCardNumber('5454545454545454')
    ->setCardHolder('Jane Jones')
    ->setCardExpiryMonth('05')
    ->setCardExpiryYear('2018')
    ->setCardCvv('123')
    ->setAmount(95.99)
    ->setCurrency('EUR')
    ->setAuthOnly(false)
    ->process();
```


Doing a pre-auth only.
```php
$preAuthorization = new \Peach\Oppwa\Payments\Debit($testClient);
$preAuthorizationResult = $preAuthorization
    ->setCardBrand(\Peach\Oppwa\Cards\Brands::MASTERCARD)
    ->setCardNumber('5454545454545454')
    ->setCardHolder('Jane Jones')
    ->setCardExpiryMonth('05')
    ->setCardExpiryYear('2018')
    ->setCardCvv('123')
    ->setAmount(95.99)
    ->setCurrency('EUR')
    ->setAuthOnly(true)
    ->process();
```

Doing a capture.
```php
$capture = new \Peach\Oppwa\Payments\Capture($testClient, $preAuthorizationResult->getId(), '95.99', 'EUR');
$captureResult = $capture->process();
```

Doing a reversal (please note no value or currency provided).
```php
$reverse = new \Peach\Oppwa\Payments\Reverse($testClient, $captureResult->getId());
$reverseResult = $reverse->process();
```
Doing a refund (please note I DID provide a value and currency)
```php
$reverse = new \Peach\Oppwa\Payments\Reverse($testClient, $captureResult->getId(), '50', 'EUR');
$reverseResult = $reverse->process();
```

