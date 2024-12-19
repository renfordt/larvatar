# Upgrade Guide
## Basic Usage / Trait
When including the `LarvatarTrait` in class you have to create now manually the following method in your class.
```php
public function getAvatar(int $size = 100, bool $encoding = true): string
    {
        $larvatar = $this->getLarvatar($this->name, $this->email);
        $larvatar->setSize($size);
        $larvatar->setWeight('600');
        return $larvatar->getImageHTML(true);
    }
```

With 2.0 the `getAvatar()` method is a abstract method in `LarvatarTrait` enabling you to modify the methods to your needs.

## Advanced Usage

Instead of running a constructor
```php
$larvatar = new Larvatar('Test Name', 'test@test.com', LarvatarTypes::InitialsAvatar);
```
you can now call the static function `make()` or `create()`:

```php
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        email: 'test@test.com'
        );
```

## Possible Avatars
You can now use the following Avatar types:
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
