<?php
namespace App\Controller;

class Base
{
    /**
     * Slim instance
     */
    private static function _getApp()
    {
        return \Slim\Slim::getInstance();
    }

    /**
     * Render JSON Response
     */
    public static function response($result, $status = 200, $error = false)
    {
        self::_getApp()
            ->render($status, array(
                'error' => $error,
                'result' => $result
            ));
    }

    /**
     * Render default JSON Response
     */
    public static function welcome()
    {
        self::response('There is a RESTful webservice in here :)');
    }
}
