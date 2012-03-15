<?php
/*
 * Base Controller
 */
class BaseController {
    function __construct() {
        API::log_api_request(get_class($this));
    }
}
?>
