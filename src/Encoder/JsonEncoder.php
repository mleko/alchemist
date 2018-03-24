<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Encoder;


use Mleko\Alchemist\Encoder;

class JsonEncoder implements Encoder
{

    /**
     * @param array|int|string|float|bool $scalar
     * @param string $format
     * @param array $context
     * @return string
     */
    public function encode($scalar, string $format, array $context = []) {
        return \json_encode($scalar);
    }

    /**
     * @param string $data
     * @param string $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function decode(string $data, string $format, array $context = []) {
        return \json_decode($data, true);
    }

    public function canProcess(string $format): bool {
        return 0 === \strcasecmp("json", $format);
    }
}
