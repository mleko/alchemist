<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test\Normalizer;

use Mleko\Alchemist\Normalizer\ScalarNormalizer;
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
        $this->assertEquals("text", $normalizer->denormalize("text", "string", "*"));
        $this->assertEquals(123, $normalizer->denormalize(123, "int", "*"));
    }

    public function testCanProcess() {
        $normalizer = new ScalarNormalizer();

        $this->assertTrue($normalizer->canProcess("string", "*"));
        $this->assertTrue($normalizer->canProcess("null", "*"));

        $this->assertFalse($normalizer->canProcess("Mleko\\Alchemist\\Serializer", "*"));
        $this->assertFalse($normalizer->canProcess("array", "*"));
    }
}
