<?php
if (isset($datos["valor"])) {
    $dato = $datos["valor"];
} else {
    $dato = Input::old($columna);
    if ($dato == "") {
        try {
            $dato = [];
            if ($registro) {
                foreach ($registro->{$columna}()->get() as $elemento) {
                    $dato[$elemento->id] = $elemento->pivot;
                }
            }
            //$dato = $registro->{$columna};
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
        @if ($error_campo)
        <div class="alert alert-danger">
            {{ HTML::ul($errors->get($columna)) }}
        </div>
        @endif
        <table class="table table-striped table-bordered" id='{{ $tabla . '_' . $columna }}'>
            <thead>
                <tr>
                    <td></td>
                    @foreach ($datos['columnas'] as $columnaT)
                    <td>{{ $columnaT['label'] }}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($datos["todos"] as $tablaInter)
                <?php
                $pivote = array_get($dato,$tablaInter->id,false);
                if (is_object ($pivote)){
                    $checked = true;
                    $readonly = "";
                }else{
                    $checked = false;
                    $readonly = "readonly";
                }
                ?>
                <tr>
                    <td>
                        {{ Form::checkbox($columna. "[" . $tablaInter->id ."]", $tablaInter->id, $checked, array('class' => 'chbx_'.$columna, 'id' => $columna . '_' . $tablaInter->id)) }}
                    </td>
                    @foreach ($datos['columnas'] as $columnaT)
                    <?php
                    if ($columnaT['type']=='label'){
                        $valorM = $tablaInter->{$columnaT['campo']};
                    }elseif (is_object ($pivote)){
                        $valorM = $pivote->{$columnaT['campo']};
                    }else{
                        $valorM = "";
                    }
                    ?>
                    @if ($columnaT['type']=='label')
                    <td>
                        {{ $valorM }}
                    </td>
                    @elseif ($columnaT['type']=='labelpivot')
                    <td>
                        {{ $valorM }}
                    </td>
                    @elseif ($columnaT['type']=='text')
                    <td>
                        {{ Form::text($columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id, $valorM, array('class' => 'form-control ' . $columna . '_' . $columnaT['campo'], 'id' => $columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id,$readonly)) }}
                    </td>
                    @elseif ($columnaT['type']=='number')
                    <td>
                        {{ Form::number($columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id, $valorM, array('class' => 'form-control ' . $columna . '_' . $columnaT['campo'], 'id' => $columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id,$readonly)) }}
                    </td>
                    @elseif ($columnaT['type']=='hidden')
                        {{ Form::number($columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id, $valorM, array('class' => 'form-control ' . $columna . '_' . $columnaT['campo'], 'id' => $columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id)) }}
                    @else
                    <td>
                        {{ Form::text($columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id, $valorM, array('class' => 'form-control ' . $columna . '_' . $columnaT['campo'], 'id' => $columna . "_" . $columnaT['campo'] . "_" . $tablaInter->id,$readonly)) }}
                    </td>
                    @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <span class="help-block" id="{{ $tabla . '_' . $columna }}_help">
            @if (isset($datos['description']))
            {{ $datos['description'] }}
            @endif
        </span>
    </div>
</div>

@section('selfjs')
@parent
<script>
    $(document).ready(function() {
        $(".chbx_{{$columna}}").change(function() {
            @foreach($datos['columnas'] as $columnaT)
            @if ($columnaT['type']!='label' && $columnaT['type']!='labelpivot')
            var idTemp = "#" + "{{$columna}}_{{$columnaT['campo']}}_" + $(this).val();
            console.log(idTemp);
            $(idTemp).prop("readonly", !$(this).is(":checked"));
            if ($(idTemp).is("[readonly]")) {
                $(idTemp).val("");
            }
            @endif
            @endforeach
        });
    });
</script>
@stop