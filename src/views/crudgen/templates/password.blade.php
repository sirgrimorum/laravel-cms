<?php
if (isset($datos["valor"])) {
    $dato = $datos["valor"];
} else {
    $dato = Input::old($columna);
    if ($dato == "") {
        try {
            $dato = $registro->{$columna};
        } catch (Exception $ex) {
            $dato = "";
        }
    }
}
$error_campo = false;
$claseError = '';
if ($errores == true) {
    if ($errors->has($columna)) {
        $error_campo = true;
        $claseError = 'has-error';
    } 
}
?>
<div class="form-group {{ $claseError }}">
    {{ Form::label($columna, ucfirst($datos['label']), array('class'=>$config['class_label'])) }}
    <div class="{{ $config['class_divinput'] }}">
        {{ Form::password($columna, $dato, array('class' => 'form-control ' . $config['class_input'], 'id' => $tabla . '_' . $columna, 'placeholder'=>$datos['placeholder'])) }}
        <span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
            @if (isset($datos['description']))
            {{ $datos['description'] }}
            @endif
        </span>
        @if ($error_campo)
        <div class="alert alert-danger">
            {{ $errors->get($columna)[0] }}
        </div>
        @endif
    </div>
</div>