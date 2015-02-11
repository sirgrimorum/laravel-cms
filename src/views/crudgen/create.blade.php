{{ HTML::ul($errors->all()) }}
<?php
$tabla = $config['tabla'];
$campos = $config['campos'];
$botones = $config['botones'];
if (isset($config['relaciones'])) {
    $relaciones = $config['relaciones'];
}
$url = $config['url'];

if ($config['render'] == "all") {
    $selects = array('column_name as field', 'column_type as type', 'is_nullable as null', 'column_key as key', 'column_default as default', 'extra as extra');
    $table_describes = DB::table('information_schema.columns')
            ->where('table_name', '=', $tabla)
            ->get($selects);
    foreach ($table_describes as $k => $v) {
        if (($kt = array_search($v, $table_describes)) !== false and $k != $kt) {
            unset($table_describes[$kt]);
        }
    }
}
?>
{{ Form::open(array('url' => $url)) }}
@if ($config['render'] == "all")
@foreach($table_describes as $key => $columna)
<div class="form-group">
    @if (array_key_exists($columna->field,$campos))
    @include("cms::crud.templates." . array_get($campos,$columna->field . ".tipo"))
    @elseif (stripos($columna->type,"text")!== false)
    {{ Form::label($columna->field, ucfirst($columna->field)) }}
    {{ Form::textarea($columna->field, Input::old($columna->field), array('class' => 'form-control')) }}
    @elseif (isset($relaciones[$columna->field]))
    {{ Form::label($columna->field, ucfirst($columna->field)) }}
    {{ Form::select($columna->field, $relaciones[$columna->field]["todos"], Input::old($columna->field), array('class' => 'form-control')) }}
    @elseif ($columna->field != "created_at" && $columna->field != "updated_at" && $columna->key != "PRI")
    {{ Form::label($columna->field, ucfirst($columna->field)) }}
    {{ Form::text($columna->field, Input::old($columna->field), array('class' => 'form-control')) }}
    @endif
</div>
@endforeach
@else
@foreach($campos as $columna => $datos)
@if (View::exists("cms::crudgen.templates." .$datos['tipo']))
@include("cms::crudgen.templates." . $datos['tipo'])
@else
@include("cms::crudgen.templates.text")
@endif
@endforeach
@endif
@if (count($botones)>0)
@if (is_array($botones))
@foreach ($botones as $boton)
{{ Form::submit($boton, array('class' => 'btn btn-primary')) }}
@endforeach
@else
{{ Form::submit($botones, array('class' => 'btn btn-primary')) }}
@endif
@else
{{ Form::submit(Lang::get('cms::crud.create.titulo'), array('class' => 'btn btn-primary')) }}
@endif

{{ Form::close() }}
