<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test\Normalizer;

use Mleko\Alchemist\Normalizer\ArrayNormalizer;
use Mleko\Alchemist\Normalizer\ChainNormalizer;
use Mleko\Alchemist\Normalizer\ScalarNormalizer;
use Mleko\Alchemist\Type;
use PHPUnit\Framework\TestCase;

class ArrayNormalizerTest extends TestCase
{

    public function testNormalize() {
        $normalizer = new ArrayNormalizer();
        $normalizer->setNormalizer(new ScalarNormalizer());
        $scalarArray = [1, 3, 'sampleString', 1.2, false, null];

        $this->assertEquals($scalarArray, $normalizer->normalize($scalarArray, "*"));
        $this->assertEquals($scalarArray, $normalizer->normalize(new \ArrayObject($scalarArray), "*"));

        $nestedArray = ["key" => ["sub" => [1, 3, 4]]];
        $this->assertEquals($nestedArray, $normalizer->normalize($nestedArray, "*"));
        $this->assertEquals($nestedArray, $normalizer->normalize(new \ArrayObject($nestedArray), "*"));
    }

    public function testDenormalize() {
        $normalizer = new ArrayNormalizer();
        $chainNormalizer = new ChainNormalizer([$normalizer, new ScalarNormalizer()]);
        $normalizer->setNormalizer($chainNormalizer);
        $scalarArray = [1, 3, 'sampleString', 1.2, false, null];

        $this->assertEquals($scalarArray, $normalizer->denormalize($scalarArray, new Type("array"), "*"));
        $this->assertEquals(new \ArrayObject($scalarArray), $normalizer->denormalize($scalarArray, new Type("ArrayObject"), "*"));

        $nestedArray = ["key" => ["sub" => [1, 3, 4], "sub2" => [4, 2]]];
        $this->assertEquals($nestedArray, $normalizer->denormalize($nestedArray, Type::fromString("array<array<array<int>>>"), "*"));
        $this->assertEquals(new \ArrayObject($nestedArray), $normalizer->denormalize($nestedArray, Type::fromString("ArrayObject<array<int>>"), "*"));
        $this->assertEquals(
            new \ArrayObject(["key" => ["sub" => new \ArrayObject([1, 3, 4]), "sub2" => new \ArrayObject([4, 2])]]),
            $normalizer->denormalize($nestedArray, Type::fromString("ArrayObject<array<ArrayObject<int>>>"), "*")
        );
    }

    public function testCanProcess() {
        $normalizer = new ArrayNormalizer();

        $this->assertTrue($normalizer->canProcess(new Type("array"), "*"));
        $this->assertFalse($normalizer->canProcess(new Type("int"), "*"));

        $this->assertFalse($normalizer->canProcess(new Type("array", [new Type("int")]), "*"));

        $normalizer->setNormalizer(new ScalarNormalizer());

        $this->assertTrue($normalizer->canProcess(new Type("array"), "*"));
        $this->assertFalse($normalizer->canProcess(new Type("int"), "*"));

        $this->assertTrue($normalizer->canProcess(new Type("array", [new Type("int")]), "*"));
        $this->assertTrue($normalizer->canProcess(new Type("ArrayObject", [new Type("int")]), "*"));

    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot normalize array without subNormalizer
     */
    public function testNormalizeWithoutSubNormalizer() {
        (new ArrayNormalizer())->normalize([], "*");
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot denormalize array without subNormalizer
     */
    public function testDenormalizeWithoutSubNormalizer() {
        (new ArrayNormalizer())->denormalize([1], new Type("array", [new Type("int")]), "*");
    }
}
