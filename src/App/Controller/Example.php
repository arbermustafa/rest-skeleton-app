<?php
namespace App\Controller;

use \App\Model\Example as ExampleModel;

class Example extends Base
{
    public static function get($id = null)
    {
        $result = null;

        if (null === $id) {
            $result = 'welcome';
        } else {
            $result = ExampleModel::find($id);
        }

        self::response($result);
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
