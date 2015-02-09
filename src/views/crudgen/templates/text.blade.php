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
{{ Form::label($columna, ucfirst($datos['label'])) }}
{{ Form::text($columna, $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna, 'placeholder'=>$datos['placeholder'])) }}
