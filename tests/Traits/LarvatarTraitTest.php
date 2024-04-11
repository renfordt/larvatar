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
    public function testGetAvatar(string $name, string $email, LarvatarTypes $type, string $encoding = '', string $expectedData)
    {
        $result = $this->getAvatar($name, $email, $type, $encoding);
        $this->assertSame($expectedData, $result);
    }

    public function dataProviderForGetAvatarTest(): array
    {
        return [
            // Add test data here as per the format
            // ['Name', 'Email', LarvatarTypes::<type>, 'encoding', 'expectedData']
            [
                'Test Name',
                'test@test.com',
                LarvatarTypes::InitialsAvatar,
                'base64',
                '<img src="data:image/jpeg;base64,somedatastring" alt="Avatar"/>'
            ]
        ];
    }
}