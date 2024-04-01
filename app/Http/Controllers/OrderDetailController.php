<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Util;
use App\Models\OrderDetail;

class OrderDetailController extends Controller {

    public function create()
    {
        $products = DB::table('Product')
            ->select('Product.id', 'Product.name')
            ->get();
        return view('orderDetails.create', ['ref' => Util::getRef('/orderDetails'), 'products' => $products]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'order_id' => 'required',
            'no' => 'required',
            'product_id' => 'required',
            'qty' => 'required'
        ]);
        $this->validate(request(), [ 'order_id' => Rule::unique('OrderDetail', 'order_id')->where('order_id', request()->input('order_id'))->where('no', request()->input('no')) ]);
        OrderDetail::create([
            'order_id' => request()->input('order_id'),
            'no' => request()->input('no'),
            'product_id' => request()->input('product_id'),
            'qty' => request()->input('qty')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function edit($order_id, $no)
    {
        $orderDetail = OrderDetail::query()
            ->select('OrderDetail.order_id', 'OrderDetail.no', 'OrderDetail.product_id', 'OrderDetail.qty')
            ->where('OrderDetail.order_id', $order_id)
            ->where('OrderDetail.no', $no)
            ->first();
        $products = DB::table('Product')
            ->select('Product.id', 'Product.name')
            ->get();
        return view('orderDetails.edit', ['orderDetail' => $orderDetail, 'ref' => Util::getRef('/orderDetails'), 'products' => $products]);
    }

    public function update($order_id, $no)
    {
        Util::setRef();
        $this->validate(request(), [
            'order_id' => 'required',
            'no' => 'required',
            'product_id' => 'required',
            'qty' => 'required'
        ]);
        DB::table('OrderDetail')
            ->where('OrderDetail.order_id', $order_id)
            ->where('OrderDetail.no', $no)
            ->update([
            'order_id' => request()->input('order_id'),
            'no' => request()->input('no'),
            'product_id' => request()->input('product_id'),
            'qty' => request()->input('qty')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($order_id, $no)
    {
        DB::table('OrderDetail')
            ->where('OrderDetail.order_id', $order_id)
            ->where('OrderDetail.no', $no)
            ->delete();
        return back();
    }
}