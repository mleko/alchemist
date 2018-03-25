<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test\Normalizer;

use Mleko\Alchemist\Normalizer\ScalarNormalizer;
use Mleko\Alchemist\Type;
use PHPUnit\Framework\TestCase;

class ScalarNormalizerTest extends TestCase
{

    public function testNormalize() {
        $normalizer = new ScalarNormalizer();
        $this->assertEquals("text", $normalizer->normalize("text", "*"));
        $this->assertEquals(123, $normalizer->normalize(123, "*"));
    }

    public function testDenormalize() {
        $normalizer = new ScalarNormalizer();
        $this->assertEquals("text", $normalizer->denormalize("text", new Type("string"), "*"));
        $this->assertEquals(123, $normalizer->denormalize(123, new Type("int"), "*"));
    }

    public function testCanProcess() {
        $normalizer = new ScalarNormalizer();

        $this->assertTrue($normalizer->canProcess(new Type("string"), "*"));
        $this->assertTrue($normalizer->canProcess(new Type("null"), "*"));

        $this->assertFalse($normalizer->canProcess(new Type("Mleko\\Alchemist\\Serializer"), "*"));
        $this->assertFalse($normalizer->canProcess(new Type("array"), "*"));
        $this->assertFalse($normalizer->canProcess(new Type("int", [new Type("string")]), "*"));
    }
}
