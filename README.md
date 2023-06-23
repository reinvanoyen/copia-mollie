## Mollie payments for Laravel Copia

This package provides Mollie payment for Laravel Copia.

### Installation

#### 1. Composer install
Run
`composer require reinvanoyen/copia-mollie`

#### 2. Update your Copia config
Next set the payment option in your copia config (config/copia.php) to 
the MolliePayment class.

```php
<?php

return [
    'payment' => \ReinVanOyen\CopiaMollie\Payment\MolliePayment::class,
];
```

#### 3. Set your Mollie API key
Make sure you set up Mollie by setting MOLLIE_API_KEY in your environment file (.env).

#### 4. Profit

### More info on Laravel Copia
https://github.com/reinvanoyen/laravel-copia/
