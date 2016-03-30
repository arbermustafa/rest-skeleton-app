<?php
namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = array('firstname', 'lastname', 'email', 'password');
    protected $guarded = array('id', 'token', 'last_login');
    protected $hidden = array('password');
    public $timestamps = false;

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucfirst(strtolower($value));
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucfirst(strtolower($value));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = md5($value);
    }

    public static function getSingle($id)
    {
        return static::findOrFail((int) $id)->toArray();
    }

    public static function getList($page, $itemsPerPage)
    {
        $offset = ((int) $page === 0) ? 1 : ((int) $page - 1) * $itemsPerPage;
        $users = static::select('id', 'firstname', 'lastname', 'email', 'last_login')
            ->skip($offset)
            ->take($itemsPerPage)
            ->orderBy('firstname', 'asc')
            ->orderBy('lastname', 'asc')
            ->get();

        return $users->toArray();
    }
}
