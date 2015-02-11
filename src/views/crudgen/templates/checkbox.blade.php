<?php
$dato = Input::old($columna);
if ($dato == "") {
    try {
        $dato = $registro->{$columna};
    } catch (Exception $ex) {
        $dato = "";
    }
}
?>
@if (is_array($datos['valor']))
@foreach($datos['valor'] as $valor)
<div class="checkbox">
    <label>
        {{ Form::checkbox($columna, $valor['valor'], $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna . '_' . $valor['valor'])) }}
    </label>
    {{ $valor['label'] }}
    <span class="help-block" id="{{ $tabla . '_' . $columna . '_' . $valor['valor'] }}_help">
        @if (isset($valor['description'])
        {{ $valor['description'] }}
        @endif
    </span>
</div>
@endforeach
@else
<div class="checkbox">
    <label>
        {{ Form::checkbox($columna, $datos['valor'], $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna)) }}
    </label>
    {{ $datos['label'] }}
    <span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
        @if (isset($datos['description'])
        {{ $datos['description'] }}
        @endif
    </span>
</div>
@endif