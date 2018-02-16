<?php

namespace Sirgrimorum\Cms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sirgrimorum\Cms\Translations\BindTranslationsToJs;
use Sirgrimorum\Cms\TransArticles\GetArticleFromDataBase;
use Sirgrimorum\Cms\CrudLoader\CrudGenerator;
use Config;
use Blade;
use Illuminate\Support\Facades\Validator;
use Sirgrimorum\Cms\CrudLoader\ExtendedValidator;

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
        /**
         * Config and publishers
         */
        include __DIR__ . '/../routes.php';

        $this->loadViewsFrom(__DIR__ . '/Views', 'sirgrimorum_cms');
        $this->loadTranslationsFrom(__DIR__ . '/Lang', 'sirgrimorum_cms');
        $this->publishes([
            __DIR__ . '/Lang' => resource_path('lang/vendor/sirgrimorum_cms'),
                ], 'lang');
        $this->publishes([
            __DIR__ . '/Config/sirgrimorum_cms.php' => config_path('sirgrimorum_cms.php'),
            __DIR__ . '/Config/models' => config_path('sigrimorum/cms/models'),
                ], 'config');
        $this->publishes([
            __DIR__ . '/Assets/ckeditor' => public_path('vendor/sirgrimorum_cms/ckeditor'),
                ], 'ckeditor');
        $this->publishes([
            __DIR__ . '/Assets/jquerytables' => public_path('vendor/sirgrimorum_cms/jquerytables'),
                ], 'jquerytables');
        $this->publishes([
            __DIR__ . '/Assets/slider' => public_path('vendor/sirgrimorum_cms/slider'),
                ], 'slider');
        $this->publishes([
            __DIR__ . '/Assets/bootstrap-3.3.7' => public_path('vendor/sirgrimorum_cms/bootstrap3'),
                ], 'bootstrap3');
        $this->publishes([
            __DIR__ . '/Assets/confirm' => public_path('vendor/sirgrimorum_cms/confirm'),
                ], 'confirm');
        $this->publishes([
            __DIR__ . '/Assets/datetimepicker' => public_path('vendor/sirgrimorum_cms/datetimepicker'),
                ], 'datetimepicker');

        /**
         * New Blade directives
         */
        Blade::directive('translation_get', function($expression) {
            list($langfile, $group) = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            $translations = new \Sirgrimorum\Cms\Translations\BindTranslationsToJs($this->app, config('sirgrimorum_cms.bind_trans_vars_to_this_view', 'welcome'), config('sirgrimorum_cms.trans_group', 'mensajes'), config('sirgrimorum_cms.default_base_var', 'translations'));
            return $translations->get($langfile, $group);
        });
        Blade::directive('translation_getarticle', function($expression) {
            $translations = new \Sirgrimorum\Cms\Translations\BindTranslationsToJs($this->app, config('sirgrimorum_cms.bind_trans_vars_to_this_view', 'welcome'), config('sirgrimorum_cms.trans_group', 'mensajes'), config('sirgrimorum_cms.default_base_var', 'translations'));
            return $translations->getarticle(str_replace(['(', ')', ' ', '"', "'"], '', $expression));
        });

        /**
         * Extended validator
         */
        Validator::resolver(
                function($translator, $data, $rules, $messages, $customAttributes ) {
                $messages["unique_composite"]=trans("sirgrimorum_cms::admin.error_messages.unique_composite");
            return new ExtendedValidator($translator, $data, $rules, $messages, $customAttributes);
        }
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias(
                    'TransArticles', \Sirgrimorum\Cms\TransArticles\Facades\TransArticle::class
            );
            $loader->alias(
                    'Translations', \Sirgrimorum\Cms\Translations\Facades\Translations::class
            );
            $loader->alias(
                    'CrudLoader', \Sirgrimorum\Cms\CrudLoader\Facades\CrudLoader::class
            );
        });
        $this->mergeConfigFrom(
                __DIR__ . '/Config/sirgrimorum_cms.php', 'sirgrimorum_cms'
        );
        $this->app->bind('TransArticles', function($app) {
            return new GetArticleFromDataBase($app->getLocale());
        });
        $this->app->bind('CrudLoader', function($app) {
            return new CrudGenerator($app);
        });
        $this->app->bind('Translations', function($app) {
            $view = config('sirgrimorum_cms.bind_trans_vars_to_this_view', 'welcome');
            $group = config('sirgrimorum_cms.trans_group', 'mensajes');
            $basevar = config('sirgrimorum_cms.default_base_var', 'translations');

            return new BindTranslationsToJs($app, $view, $group, $basevar);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('TransArticles', 'Translations', 'CrudLoader');
    }

}
