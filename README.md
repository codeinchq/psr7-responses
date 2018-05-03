# PSR-7 responses

This PHP 7.1 library provides a collection of [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible responses based on the [Guzzle implementation](https://github.com/guzzle/psr7).

**The collection includes:**
* [`DebugResponse`](src/DebugResponse.php)
* [`ErrorResponse`](src/ErrorResponse.php)
* [`FileResponse`](src/FileResponse.php)
* [`ForbiddenResponse`](src/ForbiddenResponse.php)
* [`HtmlResponse`](src/HtmlResponse.php)
* [`HttpProxyResponse`](src/HttpProxyResponse.php)
* [`JsonResponse`](src/JsonResponse.php)
* [`NotFoundResponse`](src/NotFoundResponse.php)
* [`RedirectResponse`](src/RedirectResponse.php)
* [`StreamResponse`](src/StreamResponse.php)
* [`TextResponse`](src/TextResponse.php)
* [`UnauthorizedResponse`](src/UnauthorizedResponse.php)
* [`XmlResponse`](src/XmlResponse.php)

## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/psr7-responses) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/psr7-responses
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).