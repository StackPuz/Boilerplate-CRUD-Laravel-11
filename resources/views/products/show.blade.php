@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_id">Id</label>
                        <input readonly id="product_id" name="id" class="form-control form-control-sm" value="{{$product->id}}" type="number" required />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_name">Name</label>
                        <input readonly id="product_name" name="name" class="form-control form-control-sm" value="{{$product->name}}" required maxlength="50" />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_price">Price</label>
                        <input readonly id="product_price" name="price" class="form-control form-control-sm" value="{{$product->price}}" type="number" step="0.1" required />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="brand_name">Brand</label>
                        <input readonly id="brand_name" name="brand_name" class="form-control form-control-sm" value="{{$product->brand_name}}" maxlength="50" />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_name">Create User</label>
                        <input readonly id="user_account_name" name="user_account_name" class="form-control form-control-sm" value="{{$product->user_account_name}}" maxlength="50" />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4"><label class="form-label">Image</label>
                        <div><a href="/storage/products/{{$product->image}}" target="_blank" title="{{$product->image}}"><img class="img-item" src="/storage/products/{{$product->image}}" /></a></div>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-sm btn-secondary" href="{{$ref}}">Back</a>
                        <a class="btn btn-sm btn-primary" href="/products/{{$product->id}}/edit?ref={{urlencode($ref)}}">Edit</a>
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