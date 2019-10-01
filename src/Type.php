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

namespace Mleko\Alchemist;


class Type
{

    private const PATTERN = "#^(?P<generic>(?P<baseType>(?:(?:[a-zA-Z_]+)(?:(?:\\\\[a-zA-Z0-9_]+)*)))(?:<(?P<genericList>(?:\\s*(?&generic)(?:\\s*,\\s*(?&generic))*))\\s*>)?)$#";
    private const OPEN_PATTERN = "#^(?P<generic>(?P<baseType>(?:(?:[a-zA-Z_]+)(?:(?:\\\\[a-zA-Z0-9_]+)*)))(?:<(?P<genericList>(?:\\s*(?&generic)(?:\\s*,\\s*(?&generic))*))\\s*>)?)#";

    /** @var string */
    private $name;

    /** @var Type[] */
    private $subTypes;

    /**
     * Type constructor.
     * @param string $name
     * @param Type[] $subTypes
     */
    public function __construct(string $name, array $subTypes = []) {
        foreach ($subTypes as $type) {
            // kinda hacky way to trigger \TypeError, without IDE screaming about unhandled Exception
            $this->typeCheck($type);
        }
        $this->name = $name;
        $this->subTypes = $subTypes;
    }

    public static function fromString(string $type): Type {
        if (1 !== \preg_match(self::PATTERN, $type, $matches)) {
            throw new \InvalidArgumentException("Malformed type provided: " . $type);
        }
        $generics = [];
        if(isset($matches['genericList'])) {
            $generics = self::parseGenericList(trim($matches['genericList']));
        }

        return new Type($matches['baseType'], $generics);
    }

    public static function fromValue($value): Type {
        return new Type(is_object($value) ? get_class($value) : gettype($value));
    }

    private static function parseGenericList($genericList) {
        $generics = [];
        while($genericList) {
            if (1 !== \preg_match(self::OPEN_PATTERN, $genericList, $matches)) {
                throw new \InvalidArgumentException("Malformed subType provided: " . $genericList);
            }
            $generics[] = self::fromString($matches["generic"]);
            $genericList = ltrim(substr($genericList, strlen($matches["generic"])));
            if ($genericList) {
                if (\substr($genericList, 0, 1) !== ",") {
                    throw new \InvalidArgumentException("Malformed subType provided: " . $genericList);
                }
                $genericList = ltrim(\substr($genericList, 1));
            }
        }
        return $generics;
    }

    public function getName(): string {
        return $this->name;
    }

    /**
     * @return Type[]
     */
    public function getSubTypes(): array {
        return $this->subTypes;
    }

    public function __toString() {
        return $this->getName() . ($this->getSubTypes() ? "<" . \implode(", ", \array_map("strval", $this->getSubTypes())) . ">" : "");
    }

    private function typeCheck(Type $type) {
        // noop
    }

}
