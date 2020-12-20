<?php
namespace Clooser\Packages\ButtonGroup\Html;

class Attribute {

    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /**
     * Attribute constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    protected function getValue(): string
    {
        return str_replace('"', '', $this->value);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        if ($this->value !== null) {
            return "{$this->name}=\"{$this->getValue()}\"";
        }
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
