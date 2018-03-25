<?php
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Normalizer;

interface NormalizerAware
{

    public function setNormalizer(Normalizer $normalizer): void;
}
