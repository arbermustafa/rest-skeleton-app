<?php
namespace App\Controller;

use \App\Model\User as UserModel;

class User extends Base
{
    public static function get($id = null)
    {
        $result = null;

        if (null === $id) {
            $result = UserModel::getList(1, 10);
        } else {
            $result = UserModel::getSingle($id);
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
