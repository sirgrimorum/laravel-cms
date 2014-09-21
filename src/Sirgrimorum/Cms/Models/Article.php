<?php

namespace Sirgrimorum\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    public function scopeFindArticle($query,$name) {
        $segments = explode(".", $name);
        $scope = array_shift($segments);
        $nickname = implode(".", $segments);
        return $query->where("scope", "=", $scope)->where("nickname", "=", $nickname);
    }

}
