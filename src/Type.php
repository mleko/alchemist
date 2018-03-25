<?php
declare(strict_types=1);

namespace Mleko\Alchemist;


class Type
{

    private const PATTERN = "#^(?P<generic>(?P<baseType>(([a-zA-Z]+)|((\\\\[a-zA-Z_][a-zA-Z0-9_]*)+)))(<(?P<genericList>((?&generic)(\\s*,\\s*(?&generic))*))>)?)$#";

    /** @var string */
    private $name;

    /** @var Type[] */
    private $subTypes;


    public function __construct(string $name, ?array $subTypes = []) {
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
        $generics = isset($matches['genericList']) ? $matches['genericList'] : '';
        $generics = \array_filter(\explode(",", $generics));

        return new Type($matches['baseType'], array_map([Type::class, "fromString"], $generics));
    }

    public static function fromValue($value): Type {
        return new Type(is_object($value) ? get_class($value) : gettype($value));
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
