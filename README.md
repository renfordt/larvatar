# Larvatar
___
![php workflow](https://github.com/renfordt/larvatar/actions/workflows/php.yml/badge.svg)
[![Latest Version](https://img.shields.io/packagist/v/renfordt/larvatar?label=version)](https://packagist.org/packages/renfordt/larvatar/)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/renfordt/larvatar/php)
[![Maintainability](https://api.codeclimate.com/v1/badges/af7c56b1f1338a9af607/maintainability)](https://codeclimate.com/github/renfordt/larvatar/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/af7c56b1f1338a9af607/test_coverage)](https://codeclimate.com/github/renfordt/larvatar/test_coverage)
![Packagist Downloads](https://img.shields.io/packagist/dt/renfordt/larvatar)

Larvatar is a package that combines different avatar styles, like Gravatar, Initials Avatar.

![Avatar Types](avatars.png)
## Installation
```
composer require renfordt/larvatar
```

## Usage
The general usage is quite simple. Create a new Larvatar class, insert name and email and the avatar type you wish.
```php
<?php
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

$larvatar = new Larvatar('Test Name', 'test@test.com', LarvatarTypes::InitialsAvatar);
$larvatar->setFont('Roboto', './font/Roboto-bold.ttf');
echo $larvatar->getImageHTML();
```

There are currently eight different types of avatars available:

```php
\Renfordt\Larvatar\Enum\LarvatarTypes::InitialsAvatar;  // Microsoft Teams like avatar with initials
\Renfordt\Larvatar\Enum\LarvatarTypes::Gravatar;        // Gravatar
\Renfordt\Larvatar\Enum\LarvatarTypes::mp;              // (Gravatar) MysticPerson, simple cartoon-style silhouette (default)
\Renfordt\Larvatar\Enum\LarvatarTypes::identicon;       // (Gravatar) A geometric pattern based on a email hash 
\Renfordt\Larvatar\Enum\LarvatarTypes::monsterid;       // (Gravatar) A generated monster different colors and faces
\Renfordt\Larvatar\Enum\LarvatarTypes::wavatar;         // (Gravatar) generated faces with differing features and backgrounds
\Renfordt\Larvatar\Enum\LarvatarTypes::retro;           // (Gravatar) 8-bit arcade-style pixelated faces
\Renfordt\Larvatar\Enum\LarvatarTypes::robohash;        // (Gravatar) A generated robot with different colors, faces, etc
```
