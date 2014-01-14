<?php
namespace API\Controller;

class Frontpage extends \SlimController\SlimController
{
    public function indexAction()
    {
        require __DIR__ . '/../../../frontpage.php';
    }
}
