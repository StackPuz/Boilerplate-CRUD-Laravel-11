<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;

class Product extends Model
{
    protected $table = 'Product';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'price', 'brand_id', 'image', 'create_user', 'create_date' ];
    public $incrementing = true;
    public $timestamps = false;

    public function getCreateDateAttribute($value)
    {
        return Util::formatDateTime($value);
    }
}