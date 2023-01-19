<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Gravatar;

final class GravatarTest extends TestCase
{
    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'http://www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af',
            Gravatar::GetGravatarLink('user@example.com')
        );
    }
}