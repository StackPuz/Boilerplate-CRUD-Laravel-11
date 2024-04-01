<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;

class OrderHeader extends Model
{
    protected $table = 'OrderHeader';
    protected $primaryKey = 'id';
    protected $fillable = [ 'customer_id', 'order_date' ];
    public $incrementing = true;
    public $timestamps = false;

    public function getOrderDateAttribute($value)
    {
        return Util::formatDate($value);
    }
}