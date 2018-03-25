<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Normalizer;
use Mleko\Alchemist\Type;

class ScalarNormalizer implements Normalizer
{
    private const SUPPORTED_TYPES = ['integer', 'int', 'double', 'float', 'boolean', 'bool', 'string', 'null', 'NULL'];

    /**
     * @inheritdoc
     */
    public function normalize($value, string $format, array $context = []) {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, Type $type, string $format, array $context = []) {
        return $data;
    }

    public function canProcess(Type $type, string $format): bool {
        return \in_array($type->getName(), self::SUPPORTED_TYPES) && 0 === \count($type->getSubTypes());
    }
}
