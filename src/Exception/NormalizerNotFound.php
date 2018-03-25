<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Exception;


class NormalizerNotFound extends \RuntimeException
{
    /** @var string */
    private $type;
    /** @var string */
    private $format;

    public function __construct(string $type, string $format) {
        $this->type = $type;
        $this->format = $format;
        parent::__construct(sprintf("Not found normalizer for type[%s] format[%s]", $type, $format));
    }

    public function getType(): string {
        return $this->type;
    }

    public function getFormat(): string {
        return $this->format;
    }
}
