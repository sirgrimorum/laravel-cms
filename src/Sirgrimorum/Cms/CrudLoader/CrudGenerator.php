<?php

namespace Sirgrimorum\Cms\CrudLoader;

use Illuminate\Support\Facades\View;
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
        foreach ($config['relaciones'] as $clave => $relacion) {
            $lista = array("-" => "-");
            $modeloM = ucfirst($relacion["modelo"]);
            foreach ($modeloM::all() as $elemento) {
                $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['nombre']};
            }
            $config['relaciones'][$clave]['todos'] = $lista;
        }
        return View::make('cms::crudgen.create', array('tabla' => $config['tabla'], 'relaciones' => $config['relaciones'], 'campos' => $config['campos'], 'url' => $config['url'], 'boton' => $config['boton']));
    }

    public function show($config, $id) {
        $modeloM = ucfirst($config['modelo']);
        $registro = $modeloM::find($id);

        return View::make('cms::crugen.show', array('tabla' => $config['tabla'], 'registro' => $registro, 'relaciones' => $config['relaciones'], 'nombre' => $config['nombre'], 'url' => $config['url']));
    }

    public function edit($config, $id) {
        foreach ($config['relaciones'] as $clave => $relacion) {
            $lista = array("-" => "-");
            $modeloM = ucfirst($relacion["modelo"]);
            foreach ($modeloM::all() as $elemento) {
                $lista[$elemento->{$relacion['id']}] = $elemento->{$relacion['nombre']};
            }
            $config['relaciones'][$clave]['todos'] = $lista;
        }
        $modeloM = ucfirst($config['modelo']);
        $registro = $modeloM::find($id);

        return View::make('cms::crudgen.edit', array('tabla' => $config['tabla'], 'registro' => $registro, 'relaciones' => $config['relaciones'], 'id' => $config['id'], 'campos' => $this->campos, 'url' => $config['url'], 'boton' => $config['boton']));
    }

    public function lists($config) {
        $modeloM = ucfirst($config['modelo']);
        $registros = $modeloM::all();
        return View::make('cms::crudgen.list', array('tabla' => $config['tabla'], 'registros' => $registros, 'relaciones' => $config['relaciones'], 'identificador' => $config['id'], 'botones'=> $config['botones']));
    }

}
