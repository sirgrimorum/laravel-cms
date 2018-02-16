@extends("sirgrimorum_cms::admin/templates/html")
<?php
if (Lang::has("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular")) {
    $singulares = trans("sirgrimorum_cms::" . strtolower($modelo) . ".labels.singular");
} else {
    $singulares = $modelo;
}
?>
@section('contenido')
<div class="modal fade" id="{{$modelo}}_edit_modal" tabindex="-1" role="dialog" aria-labelledby="{{$modelo}}_edit_modalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans('sirgrimorum_cms::admin.layout.labels.close')}}"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="{{$modelo}}_edit_modalLabel">{{ trans('sirgrimorum_cms::admin.layout.editar') }} {{ ucfirst($singulares) }}</h3>
            </div>
            <div class="modal-body">
                @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::pull('message') }}</div>
                @endif
                <?php
                //$config = config(config("sirgrimorum_cms.admin_routes." . $modelo));
                //$config['botones'] = trans("sirgrimorum_cms::article.labels.edit");
                //$config['url'] = url($base_url . "/" . strtolower($modelo) . "/" . $registro . "/update");
                ?>
                {!! CrudLoader::edit($config,$registro) !!}
            </div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#{{$modelo}}_edit_modal">Launch modal</button>
@stop