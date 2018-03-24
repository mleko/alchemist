<?php
declare(strict_types=1);

namespace Mleko\Alchemist;


interface Normalizer
{
    /**
     * @param mixed $value
     * @param string $format
     * @param array $context
     * @return array|integer|double|string|boolean|null
     */
    public function normalize($value, string $format, array $context = []);

    /**
     * @param array|integer|double|string|boolean|null $data
     * @param string $type
     * @param string $format
     * @param array $context
     * @return mixed
     */
    public function denormalize($data, string $type, string $format, array $context = []);

    public function canProcess(string $type, string $format): bool;
}
