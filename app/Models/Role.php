<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;

class Role extends Model
{
    protected $table = 'Role';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name' ];
    public $incrementing = true;
    public $timestamps = false;
}