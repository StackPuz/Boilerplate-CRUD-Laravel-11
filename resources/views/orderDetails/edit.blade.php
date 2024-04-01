@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/orderDetails/{{$orderDetail->order_id}}/{{$orderDetail->no}}?ref={{urlencode($ref)}}">
                @method("PATCH")
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_detail_order_id">Order Id</label>
                        <input readonly id="order_detail_order_id" name="order_id" class="form-control form-control-sm" value="{{old('order_id', $orderDetail->order_id)}}" type="number" required />
                        @error('order_id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_detail_no">No</label>
                        <input readonly id="order_detail_no" name="no" class="form-control form-control-sm" value="{{old('no', $orderDetail->no)}}" type="number" required />
                        @error('no')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_detail_product_id">Product</label>
                        <select id="order_detail_product_id" name="product_id" class="form-select form-select-sm" required>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}" {{old('product_id', $orderDetail->product_id) == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                            @endforeach
                        </select>
                        @error('product_id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_detail_qty">Qty</label>
                        <input id="order_detail_qty" name="qty" class="form-control form-control-sm" value="{{old('qty', $orderDetail->qty)}}" type="number" required />
                        @error('qty')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="col-12">
                        <a class="btn btn-sm btn-secondary" href="{{$ref}}">Cancel</a>
                        <button class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection