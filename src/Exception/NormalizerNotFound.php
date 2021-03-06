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

namespace Mleko\Alchemist\Exception;


use Mleko\Alchemist\Type;

class NormalizerNotFound extends \RuntimeException
{
    /** @var Type */
    private $type;
    /** @var string */
    private $format;

    public function __construct(Type $type, string $format) {
        $this->type = $type;
        $this->format = $format;
        parent::__construct(sprintf("Not found normalizer for type %s, format %s", $type, $format));
    }

    public function getType(): Type {
        return $this->type;
    }

    public function getFormat(): string {
        return $this->format;
    }
}
