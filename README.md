# simple-scraper

<!-- [![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads] -->

A simple HTML scraper in PHP.


## Install

Via Composer

``` bash
$ composer require cristopherm/simple-scraper
```

## Usage

The parse method will return a object with the following properties:
* title
* tags
* description
* content

You can use a raw HTML string or an URL with the methods **loadString()** and **loadUrl()** respectively.

**Example:**

```
use Cristopherm\SimpleScraper\HtmlParser;

$file = new HtmlParser();

$result = $file
    ->loadString($rawFile)
    ->idsForCleaning(['some-id', 'another-id'])
    ->parse();
```

<!-- ## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently. -->

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email cristopher.martins@gmail.com instead of using the issue tracker.

## Credits

- [Cristopher Martins][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cristopherm/simple-scraper.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/cristopherm/simple-scraper/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/cristopherm/simple-scraper.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cristopherm/simple-scraper.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cristopherm/simple-scraper.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cristopherm/simple-scraper
[link-travis]: https://travis-ci.org/cristopherm/simple-scraper
[link-scrutinizer]: https://scrutinizer-ci.com/g/cristopherm/simple-scraper/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/cristopherm/simple-scraper
[link-downloads]: https://packagist.org/packages/cristopherm/simple-scraper
[link-author]: https://github.com/cristopherm
[link-contributors]: ../../contributors
