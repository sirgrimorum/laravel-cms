<?php
if (Lang::has("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular")) {
    $singulares = trans("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular");
} else {
    $singulares = $modelo;
}
?>
<h1>{{ ucfirst(trans('sirgrimorum_cms::' . strtolower($modelo) . '.labels.plural')) }} <a href='{{ url($base_url . "/" . $plural .'/create') }}' class='pull-right btn btn-info' ><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> {{ trans('sirgrimorum_cms::admin.layout.crear') }} {{ $singulares }}</a></h1>

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::pull('message') }}</div>
@endif
<?php
//$config = config(config("sirgrimorum_cms.admin_routes." . $modelo));
if (($textConfirm = trans('sirgrimorum_cms::' . strtolower($modelo) . '.mensajes.confirm_destroy')) == 'sirgrimorum_cms::' . strtolower($modelo) . '.mensajes.confirm_destroy') {
    $textConfirm = trans('sirgrimorum_cms::admin.mensajes.confirm_destroy');
}
$config['botones'] = [
    "<a class='btn btn-info' href='" . url($base_url . "/" . strtolower($modelo) . "/:modelId") . "' title='" . trans('sirgrimorum_cms::admin.layout.ver') . "'><span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span></a>",
    "<a class='btn btn-success' href='" . url($base_url . "/" . strtolower($modelo) . "/:modelId/edit") . "' title='" . trans('sirgrimorum_cms::admin.layout.editar') . "'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>",
    "<a class='btn btn-danger' href='" . url($base_url . "/" . strtolower($modelo) . "/:modelId/destroy") . "' data-confirm='" . $textConfirm . "' data-yes='" . $textConfirm = trans('sirgrimorum_cms::admin.layout.labels.yes') . "' data-yes='" . $textConfirm = trans('sirgrimorum_cms::admin.layout.labels.no') . "' data-confirmtheme='" . config('sirgrimorum_cms.confirm_theme') . "' data-confirmicon='" . config('sirgrimorum_cms.confirm_icon') . "' data-method='delete' rel='nofollow' title='" . trans('sirgrimorum_cms::admin.layout.borrar') . "'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>",
];
?>
{!! CrudLoader::lists($config) !!}
