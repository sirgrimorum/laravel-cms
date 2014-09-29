<?php

namespace Sirgrimorum\Cms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sirgrimorum\Cms\Translations\BindTranslationsToJs;
use Sirgrimorum\Cms\TransArticles\GetArticleFromDataBase;
use Sirgrimorum\Cms\ValidatorExtension;
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
                'TransArticle', 'Sirgrimorum\Cms\TransArticles\Facades\TransArticle'
        );
        AliasLoader::getInstance()->alias(
                'Translations', 'Sirgrimorum\Cms\Translations\Facades\Translations'
        );
        // Registering the validator extension with the validator factory
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages)
        {
            return new ValidatorExtension(
                $translator,
                $data,
                $rules,
                $messages
            );
        });
        //include our filters, view composers, and routes
        include __DIR__ . '/../filters.php';
        include __DIR__ . '/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('TransArticles', function($app) {
            return new GetArticleFromDataBase($app->getLocale());
        });
        $this->app->bind('Translations', function($app) {
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
        return array('TransArticles', 'Translations');
    }

}
