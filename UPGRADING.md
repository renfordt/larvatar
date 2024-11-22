New:
```php
$larvatar = Larvatar::make(
        type: LarvatarTypes::InitialsAvatar,
        name: 'Test Name'
        );
```


Old:
```php
$larvatar = new Larvatar('Test Name', 'test@test.com', LarvatarTypes::InitialsAvatar);
```