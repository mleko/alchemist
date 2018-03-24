<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Serializer;


use Mleko\Alchemist\Encoder;
use Mleko\Alchemist\Normalizer;
use Mleko\Alchemist\Serializer;

class BasicSerializer implements Serializer
{
    /** @var Normalizer */
    private $normalizer;
    /** @var Encoder */
    private $encoder;

    /**
     * BaseSerializer constructor.
     * @param Normalizer $normalizer
     * @param Encoder $encoder
     */
    public function __construct(Normalizer $normalizer, Encoder $encoder) {
        $this->normalizer = $normalizer;
        $this->encoder = $encoder;
    }

    public function serialize($value, string $format, array $context = []): string {
        return $this->encoder->encode(
            $this->normalizer->normalize($value, $format, $context),
            $format,
            $context
        );
    }

    public function unserialize(string $data, string $type, string $format, array $context = []) {
        return $this->normalizer->denormalize(
            $this->normalizer->denormalize($data, $type, $format, $context),
            $type,
            $format,
            $context
        );
    }
}