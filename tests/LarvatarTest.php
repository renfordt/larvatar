<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Renfordt\Larvatar\Larvatar;

final class LarvatarTest extends TestCase
{
    public function testCheckHexGeneration(): void
    {
        $larvatar = new Larvatar();
        $larvatar->setName('Test Name');

        $this->assertEquals(
            '#9c3564',
            $larvatar->generateHexColor()
        );
    }
}