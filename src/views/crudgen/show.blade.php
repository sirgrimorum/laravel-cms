<?php
$selects = array('column_name as field', 'column_type as type', 'is_nullable as null', 'column_key as key', 'column_default as default', 'extra as extra');
$table_describes = DB::table('information_schema.columns')
        ->where('table_name', '=', $tabla)
        ->get($selects);
foreach ($table_describes as $k => $v) {
    if (($kt = array_search($v, $table_describes)) !== false and $k != $kt) {
        unset($table_describes[$kt]);
    }
}
?>
<div class="jumbotron text-center">
    <h2>{{ $registro->{$nombre} }}</h2>
    <p>
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
    </p>
</div>
