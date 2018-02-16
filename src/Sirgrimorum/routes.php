<?php

Route::group(['prefix' => "{localecode}/" . config("sirgrimorum_cms.admin_prefix"), 'middleware' => 'web'], function () {
    Route::get('', function($localecode) {
        App::setLocale($localecode);
        //return $localecode;
        $callback = config('sirgrimorum_cms.permission');
        if (is_callable($callback)) {
            $resultado = (bool) $callback();
        } else {
            $resultado = (bool) $callback;
        }
        if (!$resultado) {
            return redirect(config("sirgrimorum_cms.login_path"))->with([
                        config("sirgrimorum_cms.error_messages_key") => trans('sirgrimorum_cms::admin.mensajes.permission'),
                        config("sirgrimorum_cms.login_redirect_key") => route("sirgrimorum_cms_home", ['localecode' => $localecode])
                            ]
            );
        }
        return view('sirgrimorum_cms::admin/templates/html');
    })->name('sirgrimorum_cms_home');
    Route::group(['prefix' => "{modelo}s/", 'as' => "sirgrimorum_cms_modelos::"], function() {
        Route::get('', '\Sirgrimorum\Cms\CrudLoader\CrudController@index')->name('index');
        Route::get('/create', '\Sirgrimorum\Cms\CrudLoader\CrudController@create')->name('create');
    });
    Route::group(['prefix' => "{modelo}/", 'as' => "sirgrimorum_cms_modelo::"], function() {
        Route::post('/store', '\Sirgrimorum\Cms\CrudLoader\CrudController@store')->name('store');
        Route::get('/{registro}', '\Sirgrimorum\Cms\CrudLoader\CrudController@show')->name('show');
        Route::get('/{registro}/edit', '\Sirgrimorum\Cms\CrudLoader\CrudController@edit')->name('edit');
        Route::put('/{registro}/update', '\Sirgrimorum\Cms\CrudLoader\CrudController@update')->name('update');
        Route::delete('/{registro}/destroy', '\Sirgrimorum\Cms\CrudLoader\CrudController@destroy')->name('destroy');
    });
});

Route::get(config("sirgrimorum_cms.admin_prefix"), function() {
    return redirect(route('sirgrimorum_cms_home', config("sirgrimorum_cms.default_locale")));
})->name('_sirgrimorum_cms_home');
