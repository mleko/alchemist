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

interface NormalizerAware
{

    public function setNormalizer(Normalizer $normalizer): void;
}
