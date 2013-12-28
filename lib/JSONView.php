<?php
/**
 * JSONView - view wrapper for json responses (with error code).
 */
class JSONView extends \Slim\View {

    public function render($status = 200, $data = NULL) {
        $app = \Slim\Slim::getInstance();

        $status = intval($status);

        $response = [];

        $data = $this->all();
        unset($data['flash']);

        $response['data'] = $data;

        // append error bool
        if (!$this->has('error')) {
            $response['error'] = false;
        }

        // append status code
        $response['status'] = $status;

        //add flash messages
        if(isset($this->data->flash) && is_object($this->data->flash)){
            $flash = $this->data->flash->getMessages();
            if (count($flash)) {
                $response['flash'] = $flash;
            } else {
                unset($response['flash']);
            }
        }

        $app->response()->status($status);
        $app->response()->header('Content-Type', 'application/json');
        $app->response()->body(json_encode($response));

        $app->stop();
    }

}
