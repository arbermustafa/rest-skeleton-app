<?php
namespace App\Controller;

class Category extends Base
{
    public static function get($id = null)
    {
        if (null === $id) {
            self::response('null');
        } else {
            self::response('id = ' . $id);
        }
    }

    public static function post()
    {
        self::response('welcome');
    }

    public static function put($id)
    {
        self::response('welcome');
    }

    public static function delete($id)
    {
        self::response('welcome');
    }
}
