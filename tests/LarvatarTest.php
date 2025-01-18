<?php

declare(strict_types=1);

namespace Renfordt\Larvatar\Tests;

use Faker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Gravatar;
use Renfordt\Larvatar\Identicon;
use Renfordt\Larvatar\InitialsAvatar;
use Renfordt\Larvatar\Larvatar;
use Renfordt\Larvatar\Name;

#[CoversClass(Larvatar::class)]
#[UsesClass(Gravatar::class)]
#[UsesClass(Name::class)]
#[UsesClass(InitialsAvatar::class)]
#[UsesClass(Identicon::class)]
class LarvatarTest extends TestCase
{
    public function testCreateLarvatarWithAllTypes(): void
    {
        foreach (LarvatarTypes::cases() as $type) {
            $larvatar = Larvatar::create($type, 'Test Name', 'test@example.com');
            $larvatar->setSize(100);
            $larvatar->setWeight('bold');
            $larvatar->setFontLightness(0.5);
            $larvatar->setForegroundLightness(0.5);
            $larvatar->setBackgroundLightness(0.5);
            $larvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');

            $this->assertNotEmpty($larvatar->getImageHTML());
            if ($type === LarvatarTypes::InitialsAvatar || $type === LarvatarTypes::IdenticonLarvatar) {
                $this->assertNotEmpty($larvatar->getBase64());
            } else {
                $this->assertEmpty($larvatar->getBase64());
            }
        }
    }

    public function testCreateLarvatar(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarWithMake(): void
    {
        $larvatar = Larvatar::make(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarWithCreate(): void
    {
        $larvatar = Larvatar::create(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarWithName(): void
    {
        $name = \Renfordt\Larvatar\Name::make('Test Name');
        $larvatar = Larvatar::create(LarvatarTypes::InitialsAvatar, $name, 'test@example.com');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateLarvatarException(): void
    {
        $this->expectExceptionMessage('must be of type Renfordt\Larvatar\Enum\LarvatarTypes');

        new Larvatar(700, 'Test Name', 'test@example.com');
    }

    public function testSetFont(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $larvatar->setFont('Roboto', '/../src/font/Roboto-Bold.ttf');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Roboto; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateGravatar(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::Gravatar, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMp(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::mp, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=mp&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateIdenticon(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::identicon, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=identicon&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateMonsterid(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::monsterid, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=monsterid&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateWavatar(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::wavatar, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=wavatar&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRetro(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::retro, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=retro&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    public function testCreateRobohash(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::robohash, 'Test Name', 'test@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=robohash&f=y&s=100" />',
            $larvatar->getImageHTML()
        );
    }

    /**
     * testSetSize method
     *
     * This test ensures that the setSize method in the Larvatar class works correctly.
     */
    public function testSetSize(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::mp, 'Test Name', 'test@example.com');
        $larvatar->setSize(50);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=mp&f=y&s=50" />',
            $larvatar->getImageHTML()
        );
    }

    /**
     * testSetSizeWithLargeValue method
     *
     * This test ensures that the setSize method in the Larvatar class works correctly with large values.
     */
    public function testSetSizeWithLargeValue(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::mp, 'Test Name', 'test@example.com');
        $larvatar->setSize(1000);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=mp&f=y&s=1000" />',
            $larvatar->getImageHTML()
        );
    }

    /**
     * testSetSizeWithSmallValue method
     *
     * This test ensures that the setSize method in the Larvatar class works correctly with small values.
     */
    public function testSetSizeWithSmallValue(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::mp, 'Test Name', 'test@example.com');
        $larvatar->setSize(1);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?d=mp&f=y&s=1" />',
            $larvatar->getImageHTML()
        );
    }

    /**
     * testSetWeight method
     *
     * This test ensures that the setWeight method in the Larvatar class works correctly.
     */
    public function testSetWeight(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $larvatar->setWeight('bold');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: bold; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );

        $larvatar->setWeight('lighter');
        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #852d55; text-anchor: middle; dominant-baseline: middle; font-weight: lighter; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>',
            $larvatar->getImageHTML()
        );
    }

    /**
     * testGetBase64 method
     *
     * This test ensures that the getBase64 method in the Larvatar class works correctly.
     */
    public function testGetBase64(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $this->assertMatchesRegularExpression(
            '/^data:image\/svg\+xml;base64,[A-Za-z0-9+\/]+=*$/',
            $larvatar->getBase64()
        );
    }

    /**
     * testGetBase64WithRandomName method
     *
     * This test ensures that getBase64 with randomized name still produce valid base64 string.
     */
    public function testGetBase64WithRandomName(): void
    {
        $faker = Faker\Factory::create();
        $randomName = $faker->name;
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, $randomName, 'test@example.com');
        $this->assertMatchesRegularExpression(
            '/^data:image\/svg\+xml;base64,[A-Za-z0-9+\/]+=*$/',
            $larvatar->getBase64()
        );
    }

    /**
     * testSetFontLightness method
     *
     * This test ensures that the setFontLightness method in the Larvatar class works correctly.
     */
    public function testSetFontLightness(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $larvatar->setFontLightness(0.5);

        $expectedSvg = '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #be4179; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>';

        $this->assertEquals($expectedSvg, $larvatar->getImageHTML());
    }

    /**
     * testSetFontLightnessWithExtremeValues method
     *
     * This test ensures the setFontLightness method in the Larvatar class works correctly for extreme values.
     */
    public function testSetFontLightnessWithExtremeValues(): void
    {
        $larvatar = new Larvatar(LarvatarTypes::InitialsAvatar, 'Test Name', 'test@example.com');
        $larvatar->setFontLightness(0.0);

        $expectedSvgLow = '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #000000; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>';

        $this->assertEquals($expectedSvgLow, $larvatar->getImageHTML());

        $larvatar->setFontLightness(1.0);

        $expectedSvgHigh = '<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100"><circle cx="50" cy="50" r="50" style="fill: #e5b3c9" /><text x="50%" y="55%" style="fill: #ffffff; text-anchor: middle; dominant-baseline: middle; font-weight: normal; font-family: Segoe UI, Helvetica, sans-serif; font-size: 50px">TN</text></svg>';

        $this->assertEquals($expectedSvgHigh, $larvatar->getImageHTML());
    }
}
