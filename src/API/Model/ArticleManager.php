<?php
namespace API\Model;
/**
 * Article manager
 */
class ArticleManager extends \FelixOnline\Core\BaseManager
{
    protected $table = 'article';
    protected $class = "\\API\\Model\\Article";
}
