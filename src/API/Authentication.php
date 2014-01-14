<?php
namespace API;

class Authentication
{
    const USER = 0;
    const AUTHOR = 10;
    const SECTION_EDITOR = 20;
    const WEB_EDITOR = 25;
    const SENIOR_EDITOR = 30;
    const SUPER_USER = 100;

    /**
     * Get user
     */
    public static function getUser()
    {
        $app = \SlimController\Slim::getInstance();
        $key = $app->request->headers->get('key') ? $app->request->headers->get('key') : $app->request->params('key');

        if (!$key) {
            return null;
        }

        $sql = \FelixOnline\Core\App::query(
            "SELECT
                user
            FROM api_keys
            WHERE api_key = '%s'",
            array($key));
        $user = \FelixOnline\Core\App::$db->get_var($sql);

        if (!$user) {
            return null;
        }

        return new \FelixOnline\Core\User($user);
    }

    /**
     * Authenticate current request for role level
     *
     * $key - authentication key
     * $role - [integer] minimum role level
     */
    public static function authenticateForRole($user, $role)
    {
        if (!$user || (int) $user->getRole() < $role) {
            $app = \SlimController\Slim::getInstance();
            $app->render(401, array(
                'error' => true,
                'msg' => 'You do not have permissions for this method'
            ));
            return false;
        }
        return true;
    }
}
