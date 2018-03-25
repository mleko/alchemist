<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Normalizer;

class ScalarNormalizer implements Normalizer
{

    /**
     * @inheritdoc
     */
    public function normalize($value, string $format, array $context = []) {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, string $type, string $format, array $context = []) {
        return $data;
    }

    public function canProcess(string $type, string $format): bool {
        return \in_array($type, ['integer', 'int', 'double', 'float', 'boolean', 'bool', 'string', 'null', 'NULL']);
    }
}
