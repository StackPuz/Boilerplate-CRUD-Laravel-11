@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/products/{{$product->id}}?ref={{urlencode($ref)}}" enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_id">Id</label>
                        <input readonly id="product_id" name="id" class="form-control form-control-sm" value="{{old('id', $product->id)}}" type="number" required />
                        @error('id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_name">Name</label>
                        <input id="product_name" name="name" class="form-control form-control-sm" value="{{old('name', $product->name)}}" required maxlength="50" />
                        @error('name')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_price">Price</label>
                        <input id="product_price" name="price" class="form-control form-control-sm" value="{{old('price', $product->price)}}" type="number" step="0.1" required />
                        @error('price')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_brand_id">Brand</label>
                        <select id="product_brand_id" name="brand_id" class="form-select form-select-sm" required>
                            @foreach ($brands as $brand)
                            <option value="{{$brand->id}}" {{old('brand_id', $product->brand_id) == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                        @error('brand_id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="product_image">Image</label>
                        <input type="file" accept="image/*" id="product_image" name="image" class="form-control form-control-sm" maxlength="50" />
                        <a href="/storage/products/{{old('image', $product->image)}}" target="_blank" title="{{old('image', $product->image)}}"><img class="img-item" src="/storage/products/{{old('image', $product->image)}}" /></a>
                        @error('image')<span class="text-danger">{{$message}}</span>@enderror
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