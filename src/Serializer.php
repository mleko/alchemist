<?php
declare(strict_types=1);

namespace Mleko\Alchemist;


interface Serializer
{
    public function serialize($value, string $format, array $context = []): string;

    public function unserialize(string $data, string $type, string $format, array $context = []);
}
