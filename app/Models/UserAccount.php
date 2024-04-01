<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Util;

class UserAccount extends Authenticatable
{
    protected $table = 'UserAccount';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'email', 'password', 'password_reset_token', 'active' ];
    public $incrementing = true;
    public $timestamps = false;
    protected $rememberTokenName = false;

    public function hasRole($role)
    {
        return DB::table('UserRole')
            ->join('Role', 'Role.id', 'UserRole.role_id')
            ->where('UserRole.user_id', Auth::id())
            ->where('Role.name', $role)
            ->exists();
    }

    public function getMenu() {
        return array_filter(config('menu'), function ($e) {
            if (isset($e['roles'])) {
                foreach (explode(',', $e['roles']) as $role) {
                    if ($this->hasRole($role)) {
                        return $e['show'];
                    }
                }
                return false;
            }
            else {
                return $e['show'];
            }
        });
    }
}