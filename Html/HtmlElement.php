<?php
namespace Clooser\Packages\ButtonGroup\Html;


class HtmlElement {

    /** @var string */
    protected $name;

    /** @var string */
    protected $content = null;

    /** @var array */
    protected $attributes = [];

    /**
     * HtmlElement constructor.
     * @param string $name
     * @param string|array $attributes
     * @param string $content
     */
    public function __construct($name, array $attributes = null, $content = null)
    {
        $this->name = $name;
        $this->content = $content;
        $this->setAttributes($attributes);
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    protected function getContent()
    {
        $content = '';

        if (!empty($this->content) && is_string($content)) {
            $content = $this->content;
        }
        return $content;
    }

    public function setAttributes($attributes)
    {
        if (! is_array($attributes)) {
            $attributes = [$attributes];
        }

        foreach ($attributes as $key => $value) {
            if ($value instanceof Attribute) {
                $this->attributes[] = $value;
                continue;
            }
            $this->attributes[] = new Attribute($key, $value);
        }
    }

    /**
     * @return string
     */
    protected function stringifyAttributes(): string
    {
        $string = '';
        foreach ($this->attributes as $attribute) {
            /* @var $attribute Attribute */
            $string .= " ".$attribute;
        }

        return $string;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return "<{$this->name}{$this->stringifyAttributes()}>{$this->getContent()}</{$this->name}>";
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
