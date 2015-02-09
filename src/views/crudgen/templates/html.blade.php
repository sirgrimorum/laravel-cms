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
{{ Form::textarea($columna, $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna)) }}

@section('selfjs')
{{ HTML::script("//cdn.ckeditor.com/4.4.5/full/ckeditor.js") }}
<script>
    $(document).ready(function() {
        CKEDITOR.replace( '{{ $tabla . "_" . $columna }}' );
    });
</script>
@stop
