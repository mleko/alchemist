<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test;

use Mleko\Alchemist\Type;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{

    public function testFromString() {
        $type = Type::fromString("array<array<string>>");

        $this->assertEquals("array", $type->getName());
        $this->assertCount(1, $type->getSubTypes());
        $this->assertEquals("array", $type->getSubTypes()[0]->getName());
        $this->assertEquals("string", $type->getSubTypes()[0]->getSubTypes()[0]->getName());
        $this->assertEquals("array<array<string>>", $type->__toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromStringInvalid() {
        Type::fromString("broken<type");
    }

    public function testFromStringMultiGeneric() {
        $this->markTestSkipped("TODO: allow multigenerics");
        $type = Type::fromString("Map<string, Map<string, string>>");

        $this->assertEquals("Map", $type->getName());
        $this->assertCount(2, $type->getSubTypes());
        $this->assertEquals("string", $type->getSubTypes()[0]->getName());
        $this->assertEquals("Map", $type->getSubTypes()[1]->getName());
        $this->assertCount(2, $type->getSubTypes()[1]->getSubTypes());
        $this->assertEquals("string", $type->getSubTypes()[1]->getSubTypes()[0]->getName());
        $this->assertEquals("string", $type->getSubTypes()[1]->getSubTypes()[1]->getName());
        $this->assertEquals("Map<string, Map<string, string>>", $type->__toString());
    }
}
