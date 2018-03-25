<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test\Normalizer;

use Mleko\Alchemist\Normalizer\ChainNormalizer;
use Mleko\Alchemist\Normalizer\ScalarNormalizer;
use PHPUnit\Framework\TestCase;

class ChainNormalizerTest extends TestCase
{

    public function testNormalize() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);
        $this->assertEquals("text", $normalizer->normalize("text", "*"));
    }

    public function testDenormalize() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);
        $this->assertEquals(123, $normalizer->denormalize(123, "int", "*"));
    }

    public function testCanProcess() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);

        $this->assertTrue($normalizer->canProcess("int", "*"));
        $this->assertTrue($normalizer->canProcess("string", "*"));

        $this->assertFalse($normalizer->canProcess("UnknownClass", "*"));
    }

    /**
     * @expectedException \Mleko\Alchemist\Exception\NormalizerNotFound
     */
    public function testNormalizeNotFoundNormalizer() {
        $normalizer = new ChainNormalizer([]);
        $this->assertEquals("text", $normalizer->normalize("text", "*"));
    }

    /**
     * @expectedException \Mleko\Alchemist\Exception\NormalizerNotFound
     */
    public function testDenormalizeNotFoundNormalizer() {
        $normalizer = new ChainNormalizer([]);
        $this->assertEquals(123, $normalizer->denormalize(123, "int", "*"));
    }
}
