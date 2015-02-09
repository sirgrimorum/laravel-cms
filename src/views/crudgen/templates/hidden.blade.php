<?php
if (isset($columna["valor"])){
    $dato = $columna["valor"];
}else{
    $dato = Input::old($columna);
    if ($dato == ""){
        try{
            $dato = $registro->{$columna};
        }catch (Exception $ex){
            $dato="";
        }
    }
}
?>
{{ Form::hidden($columna, $dato, array('class' => 'form-control', 'id' => $tabla . '_' . $columna)) }}
