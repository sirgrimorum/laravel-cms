<?php

$dato = Input::old($columna);
if ($dato == ""){
    try{
        $dato = $registro->{$columna};
    }catch (Exception $ex){
        $dato="";
    }
}
?>
{{ Form::label($columna->field, ucfirst($datos['label'])) }}
{{ Form::select($columna, $datos["todos"], $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna)) }}