<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Tests\Traits;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Avatar;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Gravatar;
use Renfordt\Larvatar\Identicon;
use Renfordt\Larvatar\InitialsAvatar;
use Renfordt\Larvatar\Larvatar;
use Renfordt\Larvatar\Name;
use Renfordt\Larvatar\Tests\User;

#[CoversClass(User::class)]
#[UsesClass(Avatar::class)]
#[UsesClass(InitialsAvatar::class)]
#[UsesClass(Identicon::class)]
#[UsesClass(Larvatar::class)]
#[UsesClass(Name::class)]
#[UsesClass(Gravatar::class)]
class LarvatarTraitTest extends TestCase
{
    public static function dataProviderForGetAvatarTest(): array
    {
        return [
            [
                'Test Name',
                'test@test.com',
                100,
                LarvatarTypes::InitialsAvatar,
                true,
                '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI1MCIgc3R5bGU9ImZpbGw6ICNlNWIzYzkiIC8+PHRleHQgeD0iNTAlIiB5PSI1NSUiIHN0eWxlPSJmaWxsOiAjODUyZDU1OyB0ZXh0LWFuY2hvcjogbWlkZGxlOyBkb21pbmFudC1iYXNlbGluZTogbWlkZGxlOyBmb250LXdlaWdodDogNjAwOyBmb250LWZhbWlseTogU2Vnb2UgVUksIEhlbHZldGljYSwgc2Fucy1zZXJpZjsgZm9udC1zaXplOiA1MHB4Ij5UTjwvdGV4dD48L3N2Zz4=" />'
            ],
            // additional cases...
        ];
    }

    public static function dataProviderForDifferentAvatarTypes(): array
    {
        return [
            [
                'Test Name',
                'test@test.com',
                LarvatarTypes::InitialsAvatar
            ],
            [
                'Test Name',
                'test@test.com',
                LarvatarTypes::Gravatar
            ],
            [
                'Test Name',
                'test@test.com',
                LarvatarTypes::IdenticonLarvatar
            ],
            // add other types if any...
        ];
    }

    // New test cases

    public static function dataProviderForEncodingVariations(): array
    {
        return [
            [true],
            [false],
        ];
    }

    #[DataProvider('dataProviderForGetAvatarTest')]
    public function testGetAvatar(
        string $name,
        string $email,
        int $size,
        LarvatarTypes $type,
        bool $encoding,
        string $expectedData
    ): void {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->type = $type;

        $result = $user->getAvatar($size, $encoding);
        $this->assertSame($expectedData, $result);
    }

    public function testGetAvatarWithDefaultParameters(): void
    {
        $user = new User();
        $user->name = 'Test Name';
        $user->email = 'test@test.com';
        $result = $user->getAvatar();
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForDifferentAvatarTypes')]
    public function testGetAvatarWithDifferentAvatarTypes(string $name, string $email, LarvatarTypes $type): void
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->type = $type;
        $result = $user->getAvatar(100, false);
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForEncodingVariations')]
    public function testGetAvatarWithEncodingVariations(bool $encoding): void
    {
        $user = new User();
        $user->name = 'Test Name';
        $user->email = 'test@test.com';
        $result = $user->getAvatar(100, $encoding);
        $this->assertNotEmpty($result);
    }
}
