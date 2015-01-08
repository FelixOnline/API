<?php
namespace FelixOnline\API;

/*
 * Base Controller
 */
class BaseController {
    function __construct() {
        API::log_api_request(get_class($this));
    }
}
?>
