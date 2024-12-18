<?php

namespace Traits;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Traits\LarvatarTrait;

class LarvatarTraitTest extends TestCase
{
    use LarvatarTrait;

    private string $name = 'Test Name';
    private string $email = 'test@test.com';
    private LarvatarTypes $type = LarvatarTypes::InitialsAvatar;

    public static function dataProviderForGetAvatarTest(): array
    {
        return [
            [
                'Test Name',
                'test@test.com',
                100,
                LarvatarTypes::InitialsAvatar,
                true,
                '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI1MCIgc3R5bGU9ImZpbGw6ICNlNWIzYzkiIC8+PHRleHQgeD0iNTAlIiB5PSI1NSUiIHN0eWxlPSJmaWxsOiAjODUyZDU1OyB0ZXh0LWFuY2hvcjogbWlkZGxlOyBkb21pbmFudC1iYXNlbGluZTogbWlkZGxlOyBmb250LXdlaWdodDogbm9ybWFsOyBmb250LWZhbWlseTogU2Vnb2UgVUksIEhlbHZldGljYSwgc2Fucy1zZXJpZjsgZm9udC1zaXplOiA1MHB4Ij5UTjwvdGV4dD48L3N2Zz4=" />'
            ],
            // additional cases...
        ];
    }

    public static function dataProviderForDifferentAvatarTypes(): array
    {
        return [
            [LarvatarTypes::InitialsAvatar],
            [LarvatarTypes::Gravatar],
            [LarvatarTypes::IdenticonLarvatar],
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
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $result = $this->getAvatar($size, $encoding);
        $this->assertSame($expectedData, $result);
    }

    public function getAvatar(int $size = 100, bool $encoding = true)
    {
        $larvatar = $this->getLarvatar($this->name, $this->email, $this->type);
        $larvatar->setSize($size);
        $larvatar->setWeight('normal');
        return $larvatar->getImageHTML($encoding);
    }

    public function testGetAvatarWithDefaultParameters()
    {
        $result = $this->getAvatar();
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForDifferentAvatarTypes')]
    public function testGetAvatarWithDifferentAvatarTypes(LarvatarTypes $type)
    {
        $this->type = $type;
        $result = $this->getAvatar(100, false);
        $this->assertNotEmpty($result);
    }

    #[DataProvider('dataProviderForEncodingVariations')]
    public function testGetAvatarWithEncodingVariations(bool $encoding)
    {
        $result = $this->getAvatar(100, $encoding);
        $this->assertNotEmpty($result);
    }
}
