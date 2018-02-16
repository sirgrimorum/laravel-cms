<?php

return [
    /*
      |--------------------------------------------------------------------------
      | View to Bind Translation Vars To
      |--------------------------------------------------------------------------
      |
      | Set this value to the name of the view (or partial) that
      | you want to prepend the Translation variables to.
      |
     */
    'bind_trans_vars_to_this_view' => 'layouts.includes.footer',
    /*
      |--------------------------------------------------------------------------
      | Group of the variables to bind
      |--------------------------------------------------------------------------
      |
      |
     */
    'trans_group' => 'mensajes',
    /*
      |--------------------------------------------------------------------------
      | Default name of the var for translations in js
      |--------------------------------------------------------------------------
      |
      |
     */
    'default_base_var' => 'translations',
    /*
      |--------------------------------------------------------------------------
      | Default language
      |--------------------------------------------------------------------------
      |
      |
     */
    'default_locale' => 'en',
    'list_locales' => ['en', 'es'],
    /*
      |--------------------------------------------------------------------------
      | Prefix for administrator
      |--------------------------------------------------------------------------
      |
      |
     */
    'admin_prefix' => 'cms',
    /*
      |--------------------------------------------------------------------------
      |	  The permission option is the highest-level authentication check that lets you define a closure that should return true if the current user
      | is allowed to view the admin section. Any "falsey" response will send the user back to the 'login_path' defined below.
      |--------------------------------------------------------------------------
      |  @type closure
     */
    'permission' => function() {
return true;
return Auth::check();
},
    /**
     * The login path is the path where Administrator will send the user if they fail a permission check
     *
     * @type string
     */
    'login_path' => '/',
    /**
     * The logout path is the path where Administrator will send the user when they click the logout link
     *
     * @type string
     */
    'logout_path' => false,
    /**
     * This is the key of the return path that is sent with the redirection to your login_action. Session::get('redirect') will hold the return URL.
     *
     * @type string
     */
    'login_redirect_key' => 'redirect',
    /**
     * Key of the result messages sent from de CrudController. Session::get('status')
     */
    'status_messages_key' => 'status',
    /**
     * Key of the error messages sent from de CrudController. Session::get('error')
     */
    'error_messages_key' => 'error',
    /**
     * Trans prefix for configuration file in order to know is needed to translate with the following key
     */
    'trans_prefix' => '__trans__',
    /**
     * Name of the blade section that includes de js
     */
    'js_section' => '', // if empty, put scripts before forms
    /**
     * Name of the blade section that includes de css
     */
    'css_section' => '', // if empty, put links before forms
    /**
     * Path to the ckeditor js, if is in asset, just include the string for the asset
     * use 'vendor/sirgrimorum_cms/ckeditor/ckeditor.js' publishing with tag=ckeditor
     * or use 'https://cdn.ckeditor.com/4.4.5/full/ckeditor.js'
     */
    'ckeditor_path' => 'vendor/sirgrimorum_cms/ckeditor/ckeditor.js',
    /**
     * path to csss to load in ckeditor separates with , and between ""
     */
    'principal_css' => '"__asset__vendor/sirgrimorum_cms/bootstrap3/css/bootstrap.min.css__", "__asset__css/principal.css__"',
    /**
     * true if you want Sirgrimorum/Cms to load its own jquery
     */
    'own_jquery' => true,
    /**
     * true if you want Sirgrimorum/Cms to load its own bootstrap
     */
    'own_bootstrap' => true,
    /**
     * Path to the bootstrap folder, if is in asset, just include the string for the asset
     * use the .map for the files in other server
     * use 'vendor/sirgrimorum_cms/bootstrap3' publishing with tag=bootstrap3
     * includes bootstrap 3.3.7
     */
    'bootstrap_path' => 'vendor/sirgrimorum_cms/bootstrap3',
    /**
     * Path to the jquery tables folder, if is in asset, just include the string for the asset
     * use the .map for the files in other server
     * use 'vendor/sirgrimorum_cms/jquerytables' publishing with tag=jquerytables
     * includes jquery 2.1.4
     */
    'jquerytables_path' => 'vendor/sirgrimorum_cms/jquerytables',
    /**
     * Path to the jquery confirm and rails.js folder, if is in asset, just include the string for the asset
     * use 'vendor/sirgrimorum_cms/confirm' publishing with tag=confirm
     * includes jquery 2.1.4, remember to use <meta name="csrf-token" content="{{ csrf_token() }}"> <meta name="csrf-param" content="_token">
     */
    'confirm_path' => 'vendor/sirgrimorum_cms/confirm',
    /**
     * theme for the confirm window, options are 'material', 'bootstrap', 'dark', 'light'
     */
    'confirm_theme' => 'dark',
    /**
     * icon for the confirm window, options are bootstrap glyphicons 'glyphicon glyphicon-warning-sign' glyphicons or if you instaled it, fontawsome 'fas fa-question-circle'
     */
    'confirm_icon' => 'glyphicon glyphicon-warning-sign',
    /**
     * Path to the bootstrap slider folder, if is in asset, just include the string for the asset
     * use 'vendor/sirgrimorum_cms/slider' publishing with tag=slider
     * needs bootstrap 3.*
     */
    'slider_path' => 'vendor/sirgrimorum_cms/slider',
     /**
     * Path to the bootstrap datetime picker folder, if is in asset, just include the string for the asset
     * use 'vendor/sirgrimorum_cms/datetimepicker' publishing with tag=datetimepicker
     * needs bootstrap 3.*
     */
    'datetimepicker_path' => 'vendor/sirgrimorum_cms/datetimepicker',
    /**
     * Routes list for the administrator
     * "[Name of the model with first uppercase]"=>"[config path of the configuration array for the model]",
     */
    'admin_routes' => [
        "Article" => "sigrimorum.cms.models.article",
    ],
    /**
     * Probable column names of the "name" for a model, used to autobuild config, only apply for string fields
     */
    'probable_name' => ['name','nombre','title','titulo','nickname','alias','email','first_name','last_name','user_name','full_name'],
    /**
     * Probable column names of an "email" in the model, used to autobuild config, only apply for string fields
     */
    'probable_email' => ['email','e_mail','correo'],
    /**
     * Probable column names of an "url" in the model, used to autobuild config, only apply for string fields
     */
    'probable_url' => ['url','web','www','web_page','page','link','enlace','pagina','pagina_web'],
    /**
     * Probable column names of a "password" in the model, used to autobuild config, only apply for string fields
     */
    'probable_password' => ['password','clave','contrasena','pswd'],
    /**
     * Probable column names of a "html" in the model, used to autobuild config, only apply for text fields
     */
    'probable_html' => ['html','code','codigo','texto','contenido','content'],
    /**
     * Probable column names of a "file" in the model, used to autobuild config, only apply for string fields
     */
    'probable_file' => ['file','archivo','pdf','doc','document','documento'],
    /**
     * Probable column names of an "image" in the model, used to autobuild config, only apply for string fields
     */
    'probable_image' => ['image','pic','picture','avatar','foto','imagen','logo'],
];
