<?php
namespace FelixOnline\API;

class FrontpageHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();

        $article = new ArticleHelper($this->this->getArticle());

        $output['article'] = $article->getOutput();

        return $output;
    }
}
