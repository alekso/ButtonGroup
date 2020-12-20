<?php


namespace Clooser\Packages\ButtonGroup;

use Illuminate\Support\Facades\Facade;

class ButtonGroupFacade extends Facade
{
    /**
     * @see \App\ButtonGroup\ButtonGroup
     */
    protected static function getFacadeAccessor() : string
    {
        return 'ButtonGroup';
    }
}
