# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mischaguilty/vpicnhtsa.svg?style=flat-square)](https://packagist.org/packages/mischaguilty/vpicnhtsa)
[![Build Status](https://img.shields.io/travis/mischaguilty/vpicnhtsa/master.svg?style=flat-square)](https://travis-ci.org/mischaguilty/vpicnhtsa)
[![Quality Score](https://img.shields.io/scrutinizer/g/mischaguilty/vpicnhtsa.svg?style=flat-square)](https://scrutinizer-ci.com/g/mischaguilty/vpicnhtsa)
[![Total Downloads](https://img.shields.io/packagist/dt/mischaguilty/vpicnhtsa.svg?style=flat-square)](https://packagist.org/packages/mischaguilty/vpicnhtsa)

Now with number search with possible vin results;
Number search doesnt depend on case or cyrillic symbols;

## Installation

You can install the package via composer:

```bash
composer require mischa/vpicnhtsa
```

## Usage

``` php
http://127.0.0.1:8000/search/vin/SALLMAMA44A150851
http://127.0.0.1:8000/search/number/ap9810ex

```bash
php artisan search:vin SALLMAMA44A150851
php artisan search:number Ap9810еХ


// Usage description here
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mischa.guilty@gmail.com instead of using the issue tracker.

## Credits

- [Mischa Guilty](https://github.com/mischaguilty)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
