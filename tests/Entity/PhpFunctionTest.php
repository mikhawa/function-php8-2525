<?php
# tests/Entity/PhpFunctionTest.php

namespace App\Tests\Entity;

use App\Entity\PhpFunction;
use PHPUnit\Framework\TestCase;
use DateTime;

class PhpFunctionTest extends TestCase
{
    public function testPhpFunction()
    {
        $phpFunction = new PhpFunction();
        $phpFunction->setTitle('title');
        $phpFunction->setSlug('slug');
        $phpFunction->setDescription('description');
        $phpFunction->setText('text');
        $phpFunction->setVisibility(true);
        $phpFunction->setCreatedAt(new \DateTime());
        $phpFunction->setUpdatedAt(new \DateTime());

        $this->assertEquals('title', $phpFunction->getTitle());
        $this->assertEquals('slug', $phpFunction->getSlug());
        $this->assertEquals('description', $phpFunction->getDescription());
        $this->assertEquals('text', $phpFunction->getText());
        $this->assertTrue($phpFunction->isVisibility());
        $this->assertInstanceOf(DateTime::class, $phpFunction->getCreatedAt());
        $this->assertInstanceOf(DateTime::class, $phpFunction->getUpdatedAt());
    }
}
