<?php
namespace FelixOnline\API;

/*
 * User Controller
 */
class userController extends BaseController {
    function GET($matches) {
        if(array_key_exists('user', $matches)) { // category articles
            try {
                $user = new \FelixOnline\Core\User($matches['user']);
                $user = new UserHelper($user);
            } catch (\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-UserController'
                );
            }

            API::output(
                $user->getOutput()
            );
        } else {
            throw new \NotFoundException(
                'Not implemented.',
                array(),
                'API-UserController'
            );
        }
    }
}
?>
