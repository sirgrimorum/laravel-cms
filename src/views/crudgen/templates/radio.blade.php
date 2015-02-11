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
<?php
if (stripos($valor['valor'],$dato)===false){
    $checked = false;
}else{
    $checked = true;
}
?>
<div class="radio">
    <label>
        {{ Form::radio($columna, $valor['valor'], array('class' => 'form-control', 'id' => $tabla . '_' . $columna . '_' . $valor['valor']),$checked) }}
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
<?php
if ($datos['valor']==$dato){
    $checked = true;
}else{
    $checked = false;
}
?>
<div class="radio">
    <label>
        {{ Form::radio($columna, $datos['valor'], array('class' => 'form-control', 'id' => $tabla . '_' . $columna),$checked) }}
    </label>
    {{ $datos['label'] }}
    <span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
        @if (isset($datos['description'])
        {{ $datos['description'] }}
        @endif
    </span>
</div>
@endi