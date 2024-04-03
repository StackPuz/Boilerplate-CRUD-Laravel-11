@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div data-method="post" data-action="/orderHeaders/{{$orderHeader->id}}?ref={{urlencode($ref)}}">
                @method("PATCH")
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_id">Id</label>
                        <input readonly id="order_header_id" name="id" class="form-control form-control-sm" value="{{old('id', $orderHeader->id)}}" type="number" required />
                        @error('id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_customer_id">Customer</label>
                        <select id="order_header_customer_id" name="customer_id" class="form-select form-select-sm" required>
                            @foreach ($customers as $customer)
                            <option value="{{$customer->id}}" {{old('customer_id', $orderHeader->customer_id) == $customer->id ? 'selected' : ''}}>{{$customer->name}}</option>
                            @endforeach
                        </select>
                        @error('customer_id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_order_date">Order Date</label>
                        <input id="order_header_order_date" name="order_date" class="form-control form-control-sm" value="{{old('order_date', $orderHeader->order_date)}}" data-type="date" autocomplete="off" required />
                        @error('order_date')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="col-12">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderHeaderOrderDetails as $orderHeaderOrderDetail)
                                <tr>
                                    <td class="text-center">{{$orderHeaderOrderDetail->no}}</td>
                                    <td>{{$orderHeaderOrderDetail->product_name}}</td>
                                    <td class="text-end">{{$orderHeaderOrderDetail->qty}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="/orderDetails/{{$orderHeaderOrderDetail->order_id}}/{{$orderHeaderOrderDetail->no}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <form action="/orderDetails/{{$orderHeaderOrderDetail->order_id}}/{{$orderHeaderOrderDetail->no}}" method="POST">
                                            @method("DELETE")
                                            @csrf
                                            <a class="btn btn-sm btn-danger" href="#!" onclick="deleteItem(this)" title="Delete"><i class="fa fa-times"></i></a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-sm btn-primary" href="/orderDetails/create?order_detail_order_id={{$orderHeader->id}}">Add</a>
                        <hr />
                    </div>
                    <div class="col-12">
                        <a class="btn btn-sm btn-secondary" href="{{$ref}}">Cancel</a>
                        <button class="btn btn-sm btn-primary" type="button" onclick="submitForm()">Submit</button>
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