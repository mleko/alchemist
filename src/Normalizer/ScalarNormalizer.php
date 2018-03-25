<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Normalizer;

class ScalarNormalizer implements Normalizer
{

    /**
     * @param mixed $value
     * @param string $format
     * @param array $context
     * @return array|integer|double|string|boolean|null
     */
    public function normalize($value, string $format, array $context = []) {
        return $value;
    }

    /**
     * @param array|integer|double|string|boolean|null $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return mixed
     */
    public function denormalize($data, string $type, string $format, array $context = []) {
        return $data;
    }

    public function canProcess(string $type, string $format): bool {
        return \in_array($type, ['integer', 'int', 'double', 'float', 'boolean', 'bool', 'string', 'null', 'NULL']);
    }
}
