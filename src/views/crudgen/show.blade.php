@if (Session::has('message'))
<div class="alert alert-info">{{ Session::pull('message') }}</div>
@endif
@if (count($errors->all())>0)
<div class="alert alert-danger">
{{ HTML::ul($errors->all()) }}
</div>
@endif
<?php
$tabla = $config['tabla'];
$campos = $config['campos'];
$botones = $config['botones'];
if (isset($config['relaciones'])) {
    $relaciones = $config['relaciones'];
}
$identificador = $config['id'];

if (isset($config['render'])){
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
<div class="jumbotron text-center">
    <h2>{{ $registro->{$nombre} }}</h2>
    <p>
    @if (isset($config['render']))
        @foreach($table_describes as $key => $columna)
        @if (isset($relaciones[$columna->field]))
        <strong>{{ ucfirst($relaciones[$columna->field]['modelo']) }}: </strong>
            @if (count($registro->{$relaciones[$columna->field]['modelo']}))
            {{ $registro->{$relaciones[$columna->field]['modelo']}->{$relaciones[$columna->field]['nombre']} }}
            @endif
        <br>
        @else
        <strong>{{ ucfirst($columna->field) }}:</strong> {{ $registro->{$columna->field} }}<br>
        @endif
        @endforeach
    @else
        @foreach($campos as $columna => $datos)
            @if ($datos['tipo']=="relationship")
                <strong>{{ ucfirst($datos['label']) }}: </strong>
                @if (count($registro->{$datos['modelo']}))
                    {{ $registro->{$datos['modelo']}->{$datos['campo']} }}
                @endif
                <br>
            @elseif ($datos['tipo']=="select")
                <strong>{{ ucfirst($datos['label']) }}: </strong>
                {{ $datos['opciones'][$registro->{$column}] }}
                <br>
            @else
                <strong>{{ ucfirst($datos['label']) }}:</strong> {{ $registro->{$columna} }}<br>
            @endif
        @endforeach
    @endif
    </p>
</div>
