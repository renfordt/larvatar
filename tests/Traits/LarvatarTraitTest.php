<?php

namespace Traits;

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Larvatar;
use Renfordt\Larvatar\Traits\LarvatarTrait;

class LarvatarTraitTest extends TestCase
{
    use LarvatarTrait;

    /**
     * @dataProvider dataProviderForGetAvatarTest
     */
    public function testGetAvatar(
        string $name,
        string $email,
        int $size,
        LarvatarTypes $type,
        string $encoding = '',
        string $expectedData
    ) {
        $result = $this->getAvatar($name, $email, $size, $type, $encoding);
        $this->assertSame($expectedData, $result);
    }

    public function dataProviderForGetAvatarTest(): array
    {
        return [
            [
                'Test Name',
                'test@test.com',
                100,
                LarvatarTypes::InitialsAvatar,
                'base64',
                '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSI1MCIgc3R5bGU9ImZpbGw6ICNlNWIzY2EiIC8+PHRleHQgeD0iNTAlIiB5PSI1NSUiIHN0eWxlPSJmaWxsOiAjODUyZTU1OyB0ZXh0LWFuY2hvcjogbWlkZGxlOyBkb21pbmFudC1iYXNlbGluZTogbWlkZGxlOyBmb250LXdlaWdodDogbm9ybWFsOyBmb250LWZhbWlseTogUm9ib3RvLHNhbnMtc2VyaWY7IGZvbnQtc2l6ZTogNTBweCI+VE48L3RleHQ+PC9zdmc+" />'
            ]
        ];
    }
}