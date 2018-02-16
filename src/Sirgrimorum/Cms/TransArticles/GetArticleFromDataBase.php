<?php

namespace SirGrimorum\Cms\TransArticles;

use Exception;
use Sirgrimorum\Cms\Models\Article;

class GetArticleFromDataBase {

    /**
     * Actual localization
     * 
     * @var string 
     */
    protected $lang;

    /**
     * 
     * @param string $lang If '' get the current localization
     */
    function __construct($lang = '') {
        if ($lang == '') {
            $this->lang = config('app.locale');
            ;
        } else {
            $this->lang = $lang;
        }
    }

    function get($nickname) {
        try {
            $article = Article::findArticle($nickname)->where("lang", "=", $this->lang)->first();
            if (count($article)) {
                return $article->content;
            } else {
                $article = Article::findArticle($nickname)->first();
                if (count($article)) {
                    return $article->content . "<small><span class='label label-warning'>" . $article->lang . "</span></small>";
                } else {
                    return $nickname;
                }
            }
        } catch (Exception $ex) {
            return $nickname . "<pre class='label label-warning'>" . print_r($ex, true) . "</pre>";
        }
    }

}
