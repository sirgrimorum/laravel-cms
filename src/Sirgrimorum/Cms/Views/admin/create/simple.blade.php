<?php
if (Lang::has("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular")) {
    $singulares = trans("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular");
} else {
    $singulares = $modelo;
}
?>
<h1>{{ trans('sirgrimorum_cms::admin.layout.crear') }} {{ ucfirst($singulares) }}</h1>

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::pull('message') }}</div>
@endif
<?php
//$config = config(config("sirgrimorum_cms.admin_routes." . $modelo));
//$config['botones'] = trans("sirgrimorum_cms::article.labels.create");
//$config['url'] = url($base_url . "/" . strtolower($modelo) . "/store");
?>
{!! CrudLoader::create($config) !!}
