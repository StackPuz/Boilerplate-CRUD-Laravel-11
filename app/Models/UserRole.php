<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;

class UserRole extends Model
{
    protected $table = 'UserRole';
    protected $primaryKey = [ 'user_id', 'role_id' ];
    protected $fillable = [ 'user_id', 'role_id' ];
    public $incrementing = false;
    public $timestamps = false;
}