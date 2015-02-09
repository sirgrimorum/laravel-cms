<?php

namespace Sirgrimorum\Cms\CrudLoader;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Exception;

class CrudGenerator {

    /**
     * Actual localization
     * 
     * @var string 
     */
    protected $lang;

    /**
     * 
     * @param string $lang If '' get the current localization
     */
    function __construct($app) {
        
    }

    function create($config) {
        if ($config['render'] == "all") {
            foreach ($config['relaciones'] as $clave => $relacion) {
                $lista = array("-" => "-");
                $modeloM = ucfirst($relacion["modelo"]);
                foreach ($modeloM::all() as $elemento) {
                    $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['nombre']};
                }
                $config['relaciones'][$clave]['todos'] = $lista;
            }
        } else {
            foreach ($config['campos'] as $clave => $relacion) {
                if ($relacion['tipo'] == "relationship") {
                    $lista = array("-" => "-");
                    $modeloM = ucfirst($relacion["modelo"]);
                    foreach ($modeloM::all() as $elemento) {
                        $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['campo']};
                    }
                    $config['campos'][$clave]['todos'] = $lista;
                }
            }
        }
        $view = View::make('cms::crudgen.create', array('config' => $config));
        return $view->render();
    }

    public function show($config, $id) {
        $modeloM = ucfirst($config['modelo']);
        $registro = $modeloM::find($id);

        $view = View::make('cms::crugen.show', array('config' => $config));
        return $view->render();
    }

    public function edit($config, $id) {
        if ($config['render'] == "all") {
            foreach ($config['relaciones'] as $clave => $relacion) {
                $lista = array("-" => "-");
                $modeloM = ucfirst($relacion["modelo"]);
                foreach ($modeloM::all() as $elemento) {
                    $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['nombre']};
                }
                $config['relaciones'][$clave]['todos'] = $lista;
            }
        } else {
            foreach ($config['campos'] as $clave => $relacion) {
                if ($relacion['tipo'] == "relationship") {
                    $lista = array("-" => "-");
                    $modeloM = ucfirst($relacion["modelo"]);
                    foreach ($modeloM::all() as $elemento) {
                        $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['campo']};
                    }
                    $config['campos'][$clave]['todos'] = $lista;
                }
            }
        }
        $modeloM = ucfirst($config['modelo']);
        $registro = $modeloM::find($id);

        $view = View::make('cms::crudgen.edit', array('config' => $config));
        return $view->render();
    }

    public function lists($config) {
        $modeloM = ucfirst($config['modelo']);
        $registros = $modeloM::all();
        $view = View::make('cms::crudgen.list', array('config' => $config));
        return $view->render();
    }

}
