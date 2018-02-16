@extends("sirgrimorum_cms::admin/templates/html")
<?php
if (Lang::has("sirgrimorum_cms::" . strtolower($modelo) . ".labels.plural")) {
    $plurales = trans("sirgrimorum_cms::" . strtolower($modelo) . ".labels.plural");
} else {
    $plurales = $plural;
}
if (Lang::has("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular")) {
    $singulares = trans("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular");
} else {
    $singulares = $modelo;
}
?>
@section('menuobj')
<li><a href="{{ URL::to($base_url . "/" . $plural .'/create') }}">{{ trans('sirgrimorum_cms::admin.layout.crear') }} {{ $singulares }}</a></li>
@stop

@section('contenido')
<ol class="breadcrumb">
    <li><a href="{{ url($base_url . "/" . $plural) }}">{{ ucfirst($plurales) }}</a></li>
    <li class="active">{{ trans('sirgrimorum_cms::admin.layout.ver') }} {{ ucfirst($singulares) }}</li>
</ol>
<!--h1>{{ trans('sirgrimorum_cms::admin.layout.ver') }} {{ ucfirst($singulares) }}</h1-->

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::pull('message') }}</div>
@endif
<?php
//$config = config(config("sirgrimorum_cms.admin_routes." . $modelo));
$config['botones'] = trans("sirgrimorum_cms::article.labels.create");
?>
<div class='container'>
    {!! CrudLoader::show($config,$registro) !!}
</div>
@stop
