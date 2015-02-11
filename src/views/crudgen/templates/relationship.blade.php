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
{{ Form::select($columna, $datos["todos"], $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna)) }}
<span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
    @if (isset($datos['description'])
    {{ $datos['description'] }}
    @endif
</span>
