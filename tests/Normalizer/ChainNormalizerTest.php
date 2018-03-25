<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Test\Normalizer;

use Mleko\Alchemist\Normalizer\ArrayNormalizer;
use Mleko\Alchemist\Normalizer\ChainNormalizer;
use Mleko\Alchemist\Normalizer\ScalarNormalizer;
use Mleko\Alchemist\Type;
use PHPUnit\Framework\TestCase;

class ChainNormalizerTest extends TestCase
{

    public function testNormalize() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);
        $this->assertEquals("text", $normalizer->normalize("text", "*"));
    }

    public function testDenormalize() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);
        $this->assertEquals(123, $normalizer->denormalize(123, new Type("int"), "*"));
    }

    public function testCanProcess() {
        $normalizer = new ChainNormalizer([new ScalarNormalizer()]);

        $this->assertTrue($normalizer->canProcess(new Type("int"), "*"));
        $this->assertTrue($normalizer->canProcess(new Type("string"), "*"));

        $this->assertFalse($normalizer->canProcess(new Type("UnknownClass"), "*"));
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
        $this->assertEquals(123, $normalizer->denormalize(123, new Type("int"), "*"));
    }

    public function testChainingChains() {
        $chain1 = new ChainNormalizer([new ScalarNormalizer()]);
        $chain2 = new ChainNormalizer([new ArrayNormalizer()]);
        $chain = new ChainNormalizer([$chain1, $chain2]);

        $this->assertEquals(
            [[1]],
            $chain->normalize(new \ArrayObject([new \ArrayObject([1])]), "*")
        );
    }
}
