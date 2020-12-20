<?php
namespace Clooser\Packages\ButtonGroup;

use Clooser\Packages\ButtonGroup\Exceptions\ButtonGroupException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ButtonGroupServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $stackName = 'scripts';
    protected $jsFile = '/javascript/package.button.group.js';

    public function boot()
    {
        $app = $this->app;
        $view = $this->app->view;

        $js = $this->getJsFile();

        //catch event when ButtonGroup binded in IOC
        $app->resolving(ButtonGroup::class, function ($api, $app) use ($view, $js) {
            $javascript = "<script type=\"text/javascript\">".$js."</script>";
            $view->startPrepend($this->stackName, $javascript);
        });
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'buttongroup');
    }

    public function register()
    {
        $this->app->bind(ButtonGroup::class, function () {
            return new ButtonGroup();
        });

        $this->app->alias(ButtonGroup::class, 'ButtonGroup');
    }

    private function getJsFile()
    {
        if (isset($this->jsFile) && file_exists(__DIR__.$this->jsFile)) {
            $script = file_get_contents(__DIR__ . $this->jsFile);
            return $script;
        }
        throw new ButtonGroupException('Javascript file doesnt exists');
    }
}


