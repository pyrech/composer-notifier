# composer-notifier

[![Latest Stable Version](https://poser.pugx.org/pyrech/composer-notifier/v/stable)](https://packagist.org/packages/pyrech/composer-notifier) [![Total Downloads](https://poser.pugx.org/pyrech/composer-notifier/downloads)](https://packagist.org/packages/pyrech/composer-notifier) [![Latest Unstable Version](https://poser.pugx.org/pyrech/composer-notifier/v/unstable)](https://packagist.org/packages/pyrech/composer-notifier)

composer-notifier is a plugin for Composer. It displays desktop notification when
Composer finishes install/update commands.

![Demo](Resources/demo.gif)

## Installation

You can install it either locally:

```shell
composer require "pyrech/composer-notifier"
```

or globally:

```shell
composer global require "pyrech/composer-notifier"
```

## Usage

That's it! Composer will enable automatically the plugin as soon it's
installed. Just run your Composer commands as usual :)

If you no longer want to display notifications, you can either:
- run your Composer command with the option `--no-plugins`
- uninstall the package

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/pyrech/composer-notifier/releases)
* the file listing the [changes between versions](CHANGELOG.md)

And finally some meta documentation:

* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)

## Credits

* [Loïck Piera](https://github.com/pyrech)
* [All contributors](https://github.com/pyrech/composer-notifier/graphs/contributors)

## License

composer-notifier is licensed under the MIT License - see the [LICENSE](LICENSE)
file for details.
