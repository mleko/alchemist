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
     * @param Type $type
     * @param string $format
     * @param array $context
     * @return mixed
     */
    public function denormalize($data, Type $type, string $format, array $context = []);

    public function canProcess(Type $type, string $format): bool;
}
