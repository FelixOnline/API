<?php
namespace FelixOnline\API;

/*
 * Archive Controller
 */
class versionController extends BaseController {
    function GET($matches) {
        return API::version();
    }
}
?>
