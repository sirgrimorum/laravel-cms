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
<table class="table table-striped table-bordered" id='list_{{ $tabla }}'>
    <thead>
        <tr>
        @if (isset($config['render']))
            @foreach($table_describes as $key => $columna)
            @if (isset($relaciones[$columna->field]))
            <th>{{ ucfirst($relaciones[$columna->field]['modelo']) }}</th>
            @elseif ($columna->field != "created_at" && $columna->field != "updated_at")
            <th>{{ $columna->field }}</th>
            @endif
            @endforeach
        @else
            @foreach($campos as $columna => $datos)
                <th>{{ ucfirst($datos['label']) }}</th>
            @endforeach
        @endif
        </tr>
    </thead>
    <tbody>
        @foreach($registros as $key => $value)
        <tr>
        @if (isset($config['render']))
            @foreach($table_describes as $columna)
                @if (isset($relaciones[$columna->field]))
                    @if (count($value->{$relaciones[$columna->field]['modelo']}))
                        <td>{{ $value->{$relaciones[$columna->field]['modelo']}->{$relaciones[$columna->field]['nombre']} }}</td>
                    @else
                        <td>-</td>
                    @endif
                @elseif ($columna->field != "created_at" && $columna->field != "updated_at")
                    <td>{{ $value->{$columna->field} }}</td>
                @endif
            @endforeach
        @else
            @foreach($campos as $columna => $datos)
                @if ($datos['tipo']=="relationship")
                    @if (count($value->{$datos['modelo']}))
                        <td>{{ $value->{$datos['modelo']}->{$datos['campo']} }}</td>
                    @else
                        <td>-</td>
                    @endif
                @else
                    <td>{{ $value->{$columna} }}</td>
                @endif
            @endforeach
        @endif
            @if (count($botones)>0)
            <td>
                @if (is_array($botones))
                @foreach ($botones as $boton)
                {{ str_replace("{ID}",$value[$identificador],$boton) }}
                {{ str_replace(htmlentities("{ID}"),$value[$identificador],$boton) }}
                @endforeach
                @else
                {{ str_replace("{ID}",$value[$identificador],$botones) }}
                {{ str_replace(htmlentities("{ID}"),$value[$identificador],$botones) }}
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@section("selfcss")
{{ HTML::style("packages/sirgrimorum/cms/css/jquery.dataTables.min.css") }}
{{ HTML::style("packages/sirgrimorum/cms/css/dataTables.bootstrap.css") }}
{{ HTML::style("packages/sirgrimorum/cms/css/dataTables.colReorder.min.css") }}
{{ HTML::style("packages/sirgrimorum/cms/css/dataTables.fixedHeader.min.css") }}
{{ HTML::style("packages/sirgrimorum/cms/css/dataTables.responsive.css") }}
{{ HTML::style("packages/sirgrimorum/cms/css/dataTables.tableTools.min.css") }}
@stop

@section("selfjs")
{{ HTML::script("packages/sirgrimorum/cms/js/jquery.dataTables.min.js") }}
{{ HTML::script("packages/sirgrimorum/cms/js/dataTables.bootstrap.js") }}
{{ HTML::script("packages/sirgrimorum/cms/js/dataTables.colReorder.min.js") }}
{{ HTML::script("packages/sirgrimorum/cms/js/dataTables.fixedHeader.min.js") }}
{{ HTML::script("packages/sirgrimorum/cms/js/dataTables.responsive.min.js") }}
{{ HTML::script("packages/sirgrimorum/cms/js/dataTables.tableTools.min.js") }}
<script>
    $(document).ready(function() {
        var lista_{{ $tabla }} = $('#list_{{ $tabla }}').DataTable({
            responsive: true,
            dom: 'Rlfrtip',
            tableTools: {
            sSwfPath: "/swf/copy_csv_xls_pdf.swf"
            }
        });
        new $.fn.dataTable.FixedHeader(lista_{{ $tabla }});
    });
</script>
@stop