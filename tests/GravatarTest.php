<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Enum\LarvatarTypes;
use Renfordt\Larvatar\Gravatar;

final class GravatarTest extends TestCase
{
    public function testGravatarLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::Gravatar);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    /**
     * Tests if the getHTML method generates the correct HTML image tag with default settings.
     */
    public function testGetHTMLGeneratesCorrectTag(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y&s=100" />',
            $gravatar->getHTML()
        );
    }

    /**
     * Tests if getHTML correctly handles a custom size.
     */
    public function testGetHTMLForCustomSize(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setSize(200);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y&s=200" />',
            $gravatar->getHTML()
        );
    }

    /**
     * Tests if getHTML generates the correct HTML tag for a specific gravatar type.
     */
    public function testGetHTMLForSpecificType(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::identicon);
        $this->assertEquals(
            '<img src="https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=identicon&f=y&s=100" />',
            $gravatar->getHTML()
        );
    }

    public function testGravatarDefaultLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarIdenticonLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::identicon);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=identicon&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarMonsteridLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::monsterid);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=monsterid&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarWavatarLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::wavatar);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=wavatar&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarRetroLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::retro);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=retro&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarRobohashLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::robohash);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=robohash&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }
    public function testSetTypeInitialsAvatar(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $defaultType = $gravatar->generateGravatarLink();

        $gravatar->setType(LarvatarTypes::InitialsAvatar);
        $this->assertEquals(
            $defaultType,
            $gravatar->generateGravatarLink(),
            "Setting type as InitialsAvatar should not change gravatar link as it's not supported."
        );
    }

    public function testSetTypeGravatar(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::Gravatar);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=&s=100',
            $gravatar->generateGravatarLink()
        );
    }

    public function testSetTypeMP(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::mp);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y&s=100',
            $gravatar->generateGravatarLink()
        );
    }
}
