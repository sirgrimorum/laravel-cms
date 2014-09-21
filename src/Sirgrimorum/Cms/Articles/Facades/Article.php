<?php namespace Sirgrimorum\Cms\Articles\Facades;

use Illuminate\Support\Facades\Facade;

class Article extends Facade {

    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Article';
    }

} 