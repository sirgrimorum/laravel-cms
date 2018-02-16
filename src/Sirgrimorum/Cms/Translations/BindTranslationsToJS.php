<?php

namespace Sirgrimorum\Cms\Translations;

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Exception;
use Sirgrimorum\Cms\Models\Article;

class BindTranslationsToJs {

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
        //echo "<p>Construct</p>";
        //echo "<pre>" . print_r(["viewToBind"=>$this->viewToBind,"group"=>$this->group,"basevar"=>$this->basevar] , true) . "</pre>";
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
        $transP = $file->getRequire(base_path() . '/resources/lang/' . $lang . '/' . $langfile . '.php');
        if ($this->group != "") {
            $trans = $transP[$this->group];
        } else {
            $trans = $transP;
        }
        //$translator = new Translator();
        //$trans = $translator->get($langfile . $this->group);
        if (is_array($trans)) {
            $jsarray = json_encode($trans);
        } else {
            $jsarray = $trans;
        }
        $this->event->listen("composing: {$this->viewToBind}", function() use ($jsarray, $langfile) {
            echo "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$langfile} = {$jsarray};</script>";
        });
    }

    /**
     * Return the  JavaScript 
     * 
     *
     * @param $langfile The language file to load
     * @param $group The key in the file to load use . for nesting
     */
    public function get($langfile, $group = "") {
        $lang = $this->app->getLocale();
        $file = new Filesystem();
        $transP = $file->getRequire(base_path() . '/resources/lang/' . $lang . '/' . $langfile . '.php');
        if ($group != "") {
            $trans = $transP[$group];
        } elseif ($this->group != "") {
            $trans = $transP[$this->group];
        } else {
            $trans = $transP;
        }
        //$translator = new Translator();
        //$trans = $translator->get($langfile . $this->group);
        if (is_array($trans)) {
            $jsarray = json_encode($trans);
        } else {
            $jsarray = $trans;
        }
        return "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$langfile} = {$jsarray};</script>";
    }

    /**
     * Bind the given JavaScript to the
     * view using Laravel event listeners
     *
     * @param $scope The scope to load
     */
    public function putarticle($scope) {
        $lang = $this->app->getLocale();
        $listo = false;
        try {
            $articles = Article::findArticles($scope)->where("lang", "=", $lang)->get();
            if (count($articles)) {
                $listo = true;
            } else {
                $articles = Article::findArticles($scope)->get();
                if (count($articles)) {
                    $listo = true;
                    //return $article->content . "<span class='label label-warning'>" . $article->lang . "</span>";
                } else {
                    $jsarray = $langfile;
                }
            }
        } catch (Exception $ex) {
            return $scope . " - Error:" . print_r($ex, true);
        }
        if ($listo) {
            if (count($articles)) {
                $trans = [];
                foreach ($articles as $article) {
                    $trans[$article->nickname] = $article->content;
                }
                $jsarray = json_encode($trans);
            } else {
                $jsarray = $langfile;
            }
        }
        $this->event->listen("composing: {$this->viewToBind}", function() use ($jsarray, $scope) {
            echo "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$scope} = {$jsarray};</script>";
        });
    }

    /**
     * return the JavaScript from article table
     * 
     *
     * @param $scope The scope to load
     * 
     */
    public function getarticle($scope) {
        $lang = $this->app->getLocale();
        $listo = false;
        try {
            $articles = Article::findArticles($scope)->where("lang", "=", $lang)->get();
            if (count($articles)) {
                $listo = true;
            } else {
                $articles = Article::findArticles($scope)->get();
                if (count($articles)) {
                    $listo = true;
                    //return $article->content . "<span class='label label-warning'>" . $article->lang . "</span>";
                } else {
                    $jsarray = $langfile;
                }
            }
        } catch (Exception $ex) {
            return $scope . " - Error:" . print_r($ex, true);
        }
        if ($listo) {
            if (count($articles)) {
                $trans = [];
                foreach ($articles as $article) {
                    $trans[$article->nickname] = $article->content;
                }
                $jsarray = json_encode($trans);
            } else {
                $jsarray = $langfile;
            }
        }

        return "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$scope} = {$jsarray};</script>";
    }

}
