<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;

class OrderDetail extends Model
{
    protected $table = 'OrderDetail';
    protected $primaryKey = [ 'order_id', 'no' ];
    protected $fillable = [ 'order_id', 'no', 'product_id', 'qty' ];
    public $incrementing = false;
    public $timestamps = false;
}