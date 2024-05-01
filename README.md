<p align="center">
    <a href="https://github.com/reagordi" target="_blank">
        <img src="https://raw.githubusercontent.com/reagordi/docs/main/images/logo.png" alt="Reagordi" height="100px">
    </a>
    <h1 align="center">Reagordi Serializable Closure</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/reagordi/serializable-closure/v/stable.png)](https://packagist.org/packages/reagordi/serializable-closure)
[![Total Downloads](https://poser.pugx.org/reagordi/serializable-closure/downloads.png)](https://packagist.org/packages/reagordi/serializable-closure)
[![Build status](https://github.com/reagordi/serializable-closure/workflows/build/badge.svg)](https://github.com/reagordi/serializable-closure/actions?query=workflow%3Abuild)
[![Code Coverage](https://codecov.io/gh/reagordi/serializable-closure/branch/master/graph/badge.svg)](https://codecov.io/gh/reagordi/serializable-closure)

[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Freagordi%2Fserializable-closure%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/reagordi/serializable-closure/main)

[![static analysis](https://github.com/reagordi/serializable-closure/workflows/static%20analysis/badge.svg)](https://github.com/reagordi/serializable-closure/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/reagordi/serializable-closure/coverage.svg)](https://shepherd.dev/github/reagordi/serializable-closure)
[![psalm-level](https://shepherd.dev/github/reagordi/serializable-closure/level.svg)](https://shepherd.dev/github/reagordi/serializable-closure)

Reagordi Serializable Closure provides an easy and secure way to serialize closures in PHP.

## Requirements

- PHP 8.2 or higher.

## Installation

The package could be installed with composer:

```shell
composer require reagordi/serializable-closure
```

## General usage

You may serialize a closure this way:

```php
use Reagordi\Component\SerializableClosure\SerializableClosure;

$closure = fn () => 'james';

// Recommended
SerializableClosure::setSecretKey('secret');

$serialized = serialize(new SerializableClosure($closure));
$closure = unserialize($serialized)->getClosure();

echo $closure(); // james;
```

### Caveats

* Anonymous classes cannot be created within closures.
* Attributes cannot be used within closures.
* Serializing closures on REPL environments like Laravel Tinker is not supported.
* Serializing closures that reference objects with readonly properties is not supported.


## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

### Code style

Use [Rector](https://github.com/rectorphp/rector) to make codebase follow some specific rules or
use either newest or any specific version of PHP:

```shell
./vendor/bin/rector
```

### Dependencies

Use [ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker) to detect transitive
[Composer](https://getcomposer.org/) dependencies.

## License

The Reagordi Serializable Closure is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Reagordi Group](https://reagordi.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/reagordi)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Reagordi_Framework-green.svg?style=flat)](https://reagordi.com/)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/reagordi_community)
