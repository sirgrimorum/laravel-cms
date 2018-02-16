
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::pull('message') }}</div>
@endif
<?php
//$config = config(config("sirgrimorum_cms.admin_routes." . $modelo));
$config['botones'] = trans("sirgrimorum_cms::article.labels.create");
?>
    {!! CrudLoader::show($config,$registro) !!}
