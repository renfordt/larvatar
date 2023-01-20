<?php declare(strict_types=1);
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
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarDefaultLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=mp&f=y',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarIdenticonLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::identicon);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=identicon&f=y',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarMonsteridLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::monsterid);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=monsterid&f=y',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarWavatarLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::wavatar);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=wavatar&f=y',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarRetroLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::retro);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=retro&f=y',
            $gravatar->generateGravatarLink()
        );
    }

    public function testGravatarRobohashLink(): void
    {
        $gravatar = new Gravatar('user@example.com');
        $gravatar->setType(LarvatarTypes::robohash);
        $this->assertEquals(
            'https://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af?d=robohash&f=y',
            $gravatar->generateGravatarLink()
        );
    }
}