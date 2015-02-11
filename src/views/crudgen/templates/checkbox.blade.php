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
@foreach($datos['valor'] as $valor=>$datos2)
<?php
if (stripos($valor,$dato)===false){
    $checked = false;
}else{
    $checked = true;
}
?>
<div class="checkbox">
    <label>
        {{ Form::checkbox($columna, $valor, array('class' => 'form-control', 'id' => $tabla . '_' . $columna . '_' . $valor),$checked) }}
    </label>
    {{ $datos2['label'] }}
    <span class="help-block" id="{{ $tabla . '_' . $columna . '_' . $valor }}_help">
        @if (isset($datos2['description'])
        {{ $datos2['description'] }}
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
<div class="checkbox">
    <label>
        {{ Form::checkbox($columna, $datos['valor'], array('class' => 'form-control', 'id' => $tabla . '_' . $columna),$checked) }}
    </label>
    {{ $datos['label'] }}
    <span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
        @if (isset($datos['description'])
        {{ $datos['description'] }}
        @endif
    </span>
</div>
@endif