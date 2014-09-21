<?php

namespace Sirgrimorum\Cms\Translations;

use Illuminate\Events\Dispatcher;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;

class BindTranslationsToJs{

    /**
     * @var Dispatcher
     */
    private $event;

    /**
     * @var string
     */
    private $viewToBind;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $app;

    /**
     * @var string
     */
    private $basevar;

    /**
     * @param Dispatcher $event
     * @param $viewToBindVariables
     */
    function __construct($app, $viewToBind, $group, $basevar) {
        $this->event = $app['events'];
        $this->viewToBind = $viewToBind;
        $this->app = $app;
        $this->basevar = $basevar;
        if ($group == "") {
            $this->group = "";
        } else {
            $this->group = $group;
        }
    }

    /**
     * Bind the given JavaScript to the
     * view using Laravel event listeners
     *
     * @param $langfile The language file to load
     */
    public function put($langfile) {
        $lang = $this->app->getLocale();
        $file = new Filesystem();
        $transP = $file->getRequire(base_path().'/app/lang/' . $lang . '/'. $langfile . '.php');
        $trans = $transP[$this->group];
        //$translator = new Translator();
        //$trans = $translator->get($langfile . $this->group);
        if (is_array($trans)) {
            $jsarray = json_encode($trans);
        } else {
            $jsarray = $trans;
        }
        $this->event->listen("composing: {$this->viewToBind}", function() use ($jsarray,$langfile) {
            echo "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$langfile} = {$jsarray};</script>";
        });
    }

}
