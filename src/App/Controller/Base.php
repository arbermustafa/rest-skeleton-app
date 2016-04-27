<?php
namespace App\Controller;

class Base
{
    /**
     * Slim instance
     */
    protected static function _getApp()
    {
        return \Slim\Slim::getInstance();
    }

    /**
     * Handle request params
     */
    protected static function getParams()
    {
        $request = self::_getApp()->request;

        if ($request->getMediaType() === 'application/json') {
            return self::buildArrayRequest($request->getBody());
        } else {
            return $request->params();
        }
    }

    /**
     * Build array request from body payload
     */
    protected static function buildArrayRequest($request)
    {
        if (!empty($request)) {
            $json = json_decode($request, true);

            if (!empty($json)) {
                return $json;
            }
        }

        return array();
    }

    /**
     * Render JSON Response
     */
    protected static function response($result, $status = 200, $error = false)
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
    protected static function welcome()
    {
        self::response('There is a RESTful webservice in here :)');
    }
}
