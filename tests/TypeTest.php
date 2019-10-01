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

    public function testFromStringComplexMultiGeneric() {
        $type = Type::fromString("Map<string, Map<string  , string>,Commons\Tuple<A\B\C   , D<int>,   int, Map<string   , Z>>    , string>");

        $this->assertEquals("Map", $type->getName());
        $this->assertCount(4, $type->getSubTypes());
        $this->assertEquals("string", $type->getSubTypes()[0]->getName());
        $this->assertEquals("Map", $type->getSubTypes()[1]->getName());
        $this->assertEquals("Commons\Tuple", $type->getSubTypes()[2]->getName());
        $this->assertEquals("string", $type->getSubTypes()[3]->getName());
        $this->assertCount(2, $type->getSubTypes()[1]->getSubTypes());
        $this->assertEquals("string", $type->getSubTypes()[1]->getSubTypes()[0]->getName());
        $this->assertEquals("string", $type->getSubTypes()[1]->getSubTypes()[1]->getName());
        $tuple = $type->getSubTypes()[2];
        $this->assertCount(4, $tuple->getSubTypes());
        $this->assertEquals("A\B\C", $tuple->getSubTypes()[0]->getName());
        $this->assertEquals("D", $tuple->getSubTypes()[1]->getName());
        $this->assertEquals("int", $tuple->getSubTypes()[2]->getName());
        $this->assertEquals("Map", $tuple->getSubTypes()[3]->getName());
        $this->assertEquals("Map<string, Map<string, string>, Commons\Tuple<A\B\C, D<int>, int, Map<string, Z>>, string>", $type->__toString());
    }

    /**
     * @expectedException \TypeError
     */
    public function testInvalidSubType() {
        new Type("int", ["int"]);
    }

    public function testNamespacedClass() {
        $type = Type::fromString("array<Mleko\\Alchemist\\Type>");

        $this->assertEquals("array", $type->getName());
        $this->assertCount(1, $type->getSubTypes());
        $this->assertEquals("Mleko\\Alchemist\\Type", $type->getSubTypes()[0]->getName());
    }
}
