<?php
/**
 * @copyright  Daniel Król <daniel@krol.me>
 * @license MIT
 * @package Mleko\Alchemist
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Mleko\Alchemist\Normalizer;


use Mleko\Alchemist\Normalizer;
use Mleko\Alchemist\Type;

class ArrayNormalizer implements Normalizer, NormalizerAware
{
    /** @var Normalizer|null */
    private $subNormalizer;

    /**
     * @inheritDoc
     */
    public function normalize($value, string $format, array $context = []) {
        if (null === $this->subNormalizer) {
            throw new \RuntimeException("Cannot normalize array without subNormalizer");
        }
        $data = [];
        foreach ($value as $key => $val) {
            $data[$key] = $this->subNormalizer->normalize($val, $format, $context);
        }
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, Type $type, string $format, array $context = []) {
        if (1 === \count($type->getSubTypes())) {
            if (null === $this->subNormalizer) {
                throw new \RuntimeException("Cannot denormalize array without subNormalizer");
            }
            $subType = $type->getSubTypes()[0];
            foreach ($data as $key => $value) {
                $data[$key] = $this->subNormalizer->denormalize($value, $subType, $format, $context);
            }
        }

        if ("ArrayObject" === $type->getName()) {
            return new \ArrayObject($data);
        }
        return $data;
    }

    public function canProcess(Type $type, string $format): bool {
        if (!\in_array($type->getName(), ["array", "ArrayObject"])) {
            return false;
        }
        $subTypeCount = \count($type->getSubTypes());
        if (0 === $subTypeCount) {
            return true;
        } elseif (1 === $subTypeCount && null !== $this->subNormalizer) {
            return $this->subNormalizer->canProcess($type->getSubTypes()[0], $format);
        }
        return false;
    }

    public function setNormalizer(Normalizer $normalizer): void {
        $this->subNormalizer = $normalizer;
    }
}
