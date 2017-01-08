## Corebank is a corebank api client.

Let's start digging transaction!

### Installation

- [Consume on Github](https://github.com/teepluss/corebank-client)

This project is the private repository, so you need to custom composer.json repositories.

~~~
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/teepluss/corebank-client"
    }
],
~~~

To get the latest version of `Consume` simply require it in your `composer.json` file.

~~~
"teepluss/corebank": "0.0.*"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once Corebank is installed you need to register the service provider with the application. Open up `config/app.php` and find the `providers` key.

~~~
'providers' => [

    Teepluss\Corebank\CorebankServiceProvider::class,

]
~~~

Corebank also ships with a facade which provides the static syntax for creating collections. You can register the facade in the `aliases` key of your `config/app.php` file.

~~~
'aliases' => [

    'Corebank' => Teepluss\Corebank\Facades\Corebank::class,

]
~~~

## Usage

```php

$transacctions = [
    '....'
];

$response = Corebank::setTimeout(60)->createTransactions($transactions);
$response->then(
    function ($response) {
        var_dump($response);
    },
    function ($response) {
        var_dump($response);
    }
);
```

## Support or Contact

If you have any problems, Contact teepluss@gmail.com

[![Support via PayPal](https://rawgithub.com/chris---/Donation-Badges/master/paypal.jpeg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9GEC8J7FAG6JA)
