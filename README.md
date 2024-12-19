# Larvatar

[![Badge](http://img.shields.io/badge/source-renfordt/Larvatar-blue.svg)](https://github.com/renfordt/Larvatar)
[![Packagist Version](https://img.shields.io/packagist/v/renfordt/larvatar?include_prereleases)](https://packagist.org/packages/renfordt/larvatar/)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/renfordt/larvatar/php)
![GitHub License](https://img.shields.io/github/license/renfordt/Larvatar)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/renfordt/Larvatar/php.yml?logo=github)
[![Code Climate coverage](https://img.shields.io/codeclimate/coverage/renfordt/larvatar?logo=codeclimate)](https://codeclimate.com/github/renfordt/larvatar/test_coverage)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/renfordt/larvatar?logo=codeclimate)](https://codeclimate.com/github/renfordt/larvatar/maintainability)

Larvatar is a package that combines different avatar styles, like Gravatar, Initials Avatar.

![Avatar Types](avatars.png)

## Installation

The recommended way of installing Larvatar is to use [Composer](https://getcomposer.org/). Run the following command to
install it to you project:

```
composer require renfordt/larvatar
```

## Upgrading to 2.0

Version 2.0 brings many breaking changes. Check the [Upgrade Guide](UPGRADING.md) to avoid any issues.

## Basic Usage

Include the LarvatarTrait with `use Renfordt\Larvatar\Traits\LarvatarTrait;` in your user class and add the following method:

```php
    /**
     * Generate and retrieve the avatar URL or HTML for the user.
     *
     * @param int $size The size of the avatar in pixels.
     * @param bool $encoding Whether to return the encoded image as HTML.
     * @return string The avatar as a string URL or encoded HTML.
     */
    public function getAvatar(int $size = 100, bool $encoding = true): string
    {
        $larvatar = $this->getLarvatar($this->name, $this->email);
        $larvatar->setSize(32);
        $larvatar->setWeight('600');
        return $larvatar->getImageHTML(true);
    }
```

Adjust the method as you please, only requirement is that the methods name is `getAvatar()`.

## Advanced Usage

The general usage is simple. Create a new Larvatar class, insert name and email and the avatar type you wish.

```php
<?php
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;

// Larvatar::make($type, $name = '', $email = '')
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );

// Optional settings    
$larvatar->setFont('Roboto,sans-serif', './font/Roboto-bold.ttf');
$larvatar->setSize(100);

// Get the SVG Code for embedding directly in your page
echo $larvatar->getImageHTML();

// if you need base64 encryption, currently this works only for InitialsAvatar
echo $larvatar->getImageHTML('base64');
// or if you need just the base64 string:
echo $larvatar->getBase64();
```

Alternatively you can create an instance of the `Name` class, which provides you more possibilities.

```php
$name = \Renfordt\Larvatar\Name::make('Test Name');

$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: $name
        );
```

There are currently nine different types of avatars available:

```php
// 1) Microsoft Teams like avatar with initials
\Renfordt\Larvatar\Enum\LarvatarTypes::InitialsAvatar;
// 2) Identicons with more possibilities to adjust
\Renfordt\Larvatar\Enum\LarvatarTypes::IdenticonLarvatar;

// 3) Gravatar
\Renfordt\Larvatar\Enum\LarvatarTypes::Gravatar;
// 4) (Gravatar) MysticPerson, simple cartoon-style silhouette (default)
\Renfordt\Larvatar\Enum\LarvatarTypes::mp;
// 5) (Gravatar) A geometric pattern based on an email hash
\Renfordt\Larvatar\Enum\LarvatarTypes::identicon;
// 6) (Gravatar) A generated monster different colors and faces 
\Renfordt\Larvatar\Enum\LarvatarTypes::monsterid;
// 7) (Gravatar) generated faces with differing features and backgrounds
\Renfordt\Larvatar\Enum\LarvatarTypes::wavatar;
// 8) (Gravatar) 8-bit arcade-style pixelated faces
\Renfordt\Larvatar\Enum\LarvatarTypes::retro;
// 9) (Gravatar) A generated robot with different colors, faces, etc
\Renfordt\Larvatar\Enum\LarvatarTypes::robohash;
```

## InitialsAvatar

### Forms

The InitialsAvatar gives you the possibility to choose between three different forms. A circle, which is the default, a
hexagon and a square. Choose it by using the `setForm()` method. The input is either a string or a value of the
Enum `FormTypes`.

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
$larvatar->initialsAvatar->setForm('circle');
$larvatar->initialsAvatar->setForm('square');
$larvatar->initialsAvatar->setForm('hexagon');

$larvatar->initialsAvatar->setForm(FormTypes::Circle);
$larvatar->initialsAvatar->setForm(FormTypes::Square);
$larvatar->initialsAvatar->setForm(FormTypes::Hexagon);
```

If you are using the hexagon form, you have additionally the possibility to rotate the form:

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
$larvatar->initialsAvatar->setForm(FormTypes::Hexagon);
$larvatar->initialsAvatar->setRotation(30);
```

### Colors

Usually the colors will be automatically selected by the provided name.
If you for some case want to manually set the contrast of the colors, you can use the methods `setBackgroundLightness()`
and `setTextLightness()`. The parameter is a float with a value range `0` to `1` where `0` means a darker color and `1`
is a lighter color.

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
$larvatar->initialsAvatar->setBackgroundLightness(0.1);
$larvatar->initialsAvatar->setTextLightness(0.8);
```

Additionally, you can change the offset which will generate a different color.

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
$larvatar->initialsAvatar->setOffset(4);
```

### Font Weight

You can also change the font weight with the method `setFontWeight()`.

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
$larvatar->initialsAvatar->setFontWeight('bold');
```

## Identicons (Larvatar Style)

```PHP
$larvatar = Larvatar::make(
        type: LarvatarTypes::IdenticonLarvatar,
        name: 'Test Name'
        );
        
// optional settings
$larvatar->avatar->setSymmetry(false);
$larvatar->avatar->setPixels(8);
```