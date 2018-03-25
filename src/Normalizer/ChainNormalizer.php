<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Exception\NormalizerNotFound;
use Mleko\Alchemist\Normalizer;
use Mleko\Alchemist\Type;

class ChainNormalizer implements Normalizer
{
    /** @var Normalizer[] */
    private $normalizers = [];

    /**
     * ChainNormalizer constructor.
     * @param Normalizer[] $normalizers
     */
    public function __construct(array $normalizers) {
        foreach ($normalizers as $normalizer) {
            $this->addNormalizer($normalizer);
        }
    }

    /**
     * @inheritdoc
     */
    public function normalize($value, string $format, array $context = []) {
        $type = Type::fromValue($value);
        $normalizer = $this->findTypeFormatNormalizer($type, $format);
        if (null === $normalizer) {
            throw new NormalizerNotFound($type, $format);
        }
        return $normalizer->normalize($value, $format, $context);
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, Type $type, string $format, array $context = []) {
        $normalizer = $this->findTypeFormatNormalizer($type, $format);
        if (null === $normalizer) {
            throw new NormalizerNotFound($type, $format);
        }
        return $normalizer->denormalize($data, $type, $format, $context);
    }

    public function canProcess(Type $type, string $format): bool {
        return null !== $this->findTypeFormatNormalizer($type, $format);
    }

    private function findTypeFormatNormalizer(Type $type, string $format): ?Normalizer {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->canProcess($type, $format)) {
                return $normalizer;
            }
        }
        return null;
    }

    private function addNormalizer(Normalizer $normalizer) {
        if ($normalizer instanceof NormalizerAware) {
            $normalizer->setNormalizer($this);
        }
        array_unshift($this->normalizers, $normalizer);
    }

}
