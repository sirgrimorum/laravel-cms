<?php

namespace Sirgrimorum\Cms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sirgrimorum\Cms\Translations\BindTranslationsToJs;
use Config;

class CmsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('sirgrimorum/cms');
        AliasLoader::getInstance()->alias(
            'Article',
            'Sirgrimorum\Cms\Articles\Facades\Article'
        );
        AliasLoader::getInstance()->alias(
            'Translations',
            'Sirgrimorum\Cms\Translations\Facades\Translations'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('Article', function($app) {
            return new \SirGrimorum\Cms\Articles\GetArticleFromDataBase($app->getLocale());
        });
        $this->app->bind('Translations',function($app){
            $view = Config::get('cms::config.bind_trans_vars_to_this_view');
            $group = Config::get('cms::config.trans_group');
            $basevar = Config::get('cms::config.default_base_var');
            
            return new BindTranslationsToJs($app, $view, $group, $basevar);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('Article','Translations');
    }

}