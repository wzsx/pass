<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    //
    public $table = 'api_users';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
}
