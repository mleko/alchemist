<?php
declare(strict_types=1);

use Mleko\Alchemist\Encoder\JsonEncoder;
use Mleko\Alchemist\Normalizer\ArrayNormalizer;
use Mleko\Alchemist\Normalizer\ChainNormalizer;
use Mleko\Alchemist\Normalizer\ScalarNormalizer;
use Mleko\Alchemist\Serializer\BasicSerializer;
use Mleko\Alchemist\Type;
use PHPUnit\Framework\TestCase;

class BasicSerializerTest extends TestCase
{

    public function testSerialize() {
        $serializer = $this->getSerializer();

        $actual = $serializer->serialize(new ArrayObject(["test" => new ArrayObject([1, 2, 3])]), "json");
        $this->assertEquals("{\"test\":[1,2,3]}", $actual);
    }

    public function testUnserialize() {
        $serializer = $this->getSerializer();

        $expected = new ArrayObject(["test" => new ArrayObject([1, 2, 3])]);
        $actual = $serializer->unserialize("{\"test\":[1,2,3]}", Type::fromString("ArrayObject<ArrayObject<int>>"), "json");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return BasicSerializer
     */
    private function getSerializer(): BasicSerializer {
        $serializer = new BasicSerializer(
            new ChainNormalizer([new ArrayNormalizer(), new ScalarNormalizer()]),
            new JsonEncoder()
        );
        return $serializer;
    }
}
