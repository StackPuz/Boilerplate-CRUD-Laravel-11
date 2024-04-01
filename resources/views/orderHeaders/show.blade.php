@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_id">Id</label>
                        <input readonly id="order_header_id" name="id" class="form-control form-control-sm" value="{{$orderHeader->id}}" type="number" required />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="customer_name">Customer</label>
                        <input readonly id="customer_name" name="customer_name" class="form-control form-control-sm" value="{{$orderHeader->customer_name}}" maxlength="50" />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_order_date">Order Date</label>
                        <input readonly id="order_header_order_date" name="order_date" class="form-control form-control-sm" value="{{$orderHeader->order_date}}" data-type="date" autocomplete="off" required />
                    </div>
                    <div class="col-12">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderHeaderOrderDetails as $orderHeaderOrderDetail)
                                <tr>
                                    <td class="text-center">{{$orderHeaderOrderDetail->no}}</td>
                                    <td>{{$orderHeaderOrderDetail->product_name}}</td>
                                    <td class="text-end">{{$orderHeaderOrderDetail->qty}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-sm btn-secondary" href="{{$ref}}">Back</a>
                        <a class="btn btn-sm btn-primary" href="/orderHeaders/{{$orderHeader->id}}/edit?ref={{urlencode($ref)}}">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection