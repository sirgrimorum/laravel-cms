<?php

namespace Sirgrimorum\Cms;

use Illuminate\Database\Eloquent\Model;

class Article extends Eloquent {

    public function author() {
        return $this->belongsTo('User');
    }

    public function scopeFindArticle($name) {
        $segments = explode(".", $name);
        $scope = array_shift($segments);
        $nickname = implode(".", $segments);
        return Article::where("scope", "=", $scope)->where("nickname", "=", $nickname);
    }

}
