<?php
namespace Clooser\Packages\ButtonGroup;

use Clooser\Packages\ButtonGroup\Html\Attribute;
use Clooser\Packages\ButtonGroup\Html\HtmlElement;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class ButtonGroup {
    /**
     * @var array
     */
    protected $buttons = [];
    /**
     * @var string
     */
    protected $jsFile = __DIR__.'js\button.group.js';
    /**
     * Data-id attribute for all menu buttons
     * @var string
     */
    protected $commonItemId;
    /**
     * @var array
     */
    protected $protectedAttr = ['href'];
    /**
     * ButtonGroup constructor.
     * @param $buttons
     */
    public function __construct(...$buttons)
    {
        $this->buttons = array_flip($buttons);
    }
    /**
     * @return $this
     */
    public static function new(...$buttons)
    {
        return new static(...array_values($buttons));
    }
    /**
     * @return Attribute[]
     */
    protected function controlButtonAttributes()
    {
        return [
            new Attribute('class', 'btn btn-default dropdown-toggle'),
            new Attribute('type', 'button'),
            new Attribute('data-toggle', 'dropdown'),
            new Attribute('aria-haspopup', 'true'),
            new Attribute('aria-expanded', 'true'),
        ];
    }
    /**
     * @return HtmlElement
     */
    protected function getControlButton()
    {
        $carret= new HtmlElement('span', [ new Attribute('class', 'caret')]);

        $buttonContent = $this->getControlButtonText().' '.$carret."\r\n" ;
        $button= new HtmlElement('button', $this->controlButtonAttributes(), $buttonContent);
        return $button;
    }
    /**
     * @param string $id
     * @return $this
     */
    public function id($id)
    {
        $this->commonItemId = $id;
        return $this;
    }
    /**
     * @param string $content Content Inside the link
     * @param array $attributes
     * @return $this
     */
    public function add($content, array $attributes = [])
    {
        $this->buttons[$content] = $attributes;
        return $this;
    }
    /**
     * @param $value
     * @return string
     */
    public function filterName($value)
    {
        return str_replace(" ", "_", strtolower($value));
    }
    /**
     * @return string
     */
    protected function getList()
    {
        if (!$this->buttons) {
            return '';
        }

        $buttonList = [];

        foreach ($this->buttons as $content => $attributes) {
            //default attributes
            $elementAttr = $this->getDefaultListItemAttributes($content);

            if (is_array($attributes) && !empty($attributes)) {
                foreach ($attributes as $name => $value) {
                    $name = strtolower(trim($name));
                    if (!in_array($name, $this->protectedAttr)) {
                        $elementAttr[$name]= new Attribute($name, $value);
                    }
                }
            }
            $link = new HtmlElement('a', array_values($elementAttr), $this->getMenuItemText($content));
            $buttonList[] = new HtmlElement('li', [ new Attribute('class', 'list-item')], $link);
        }

        return join("\r\n\t", $buttonList);
    }
    /**
     * @param string $content
     * @return string
     */
    protected function getMenuItemText($content)
    {
        $content = strtolower(trim($content));
        if (function_exists('trans') && Lang::has('buttongroup::buttons.'.$content)) {
            return ucfirst(trans('buttongroup::buttons.'.$content));
        }

        return ucfirst($content);
    }
    /**
     * @return string
     */
    protected function getControlButtonText()
    {
        if (function_exists('trans') && Lang::has('buttongroup::buttons.control_button')) {
            return trans('buttongroup::buttons.control_button');
        }
        return 'Manage';
    }
    /**
     * @param string $content
     * @return array
     */
    protected function getDefaultListItemAttributes($content)
    {
        $attr = [
            'href' => new Attribute('href', '#'),
            'data-action' => new Attribute('data-action', $this->filterName($content)),
        ];

        if (isset($this->commonItemId)) {
            $attr['data-id'] = new Attribute('data-id', $this->commonItemId);
        }

        return $attr;
    }
    /**
     * @return string
     */
    protected function buildUlList()
    {
        return new HtmlElement('ul', [ new Attribute('class', 'dropdown-menu')], "\r\n\t".$this->getList()."\r\n");
    }
    /**
     * @return string
     */
    public function render()
    {
        $content = $this->getControlButton()."\r\n";
        $content .= $this->buildUlList();
        $divWrapper = new HtmlElement('div', [ new Attribute('class', 'dropdown')], $content);

        return $divWrapper;
    }
    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
