<?php
/*
 * Base Controller
 */
class BaseController {
    function __construct() {
        API::log_api_request($_GET);
    }
}
?>
