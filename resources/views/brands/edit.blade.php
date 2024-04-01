@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/brands/{{$brand->id}}?ref={{urlencode($ref)}}">
                @method("PATCH")
                @csrf
                <div class="row">
                    <input type="hidden" id="brand_id" name="id" value="{{old('id', $brand->id)}}" />
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="brand_name">Name</label>
                        <input id="brand_name" name="name" class="form-control form-control-sm" value="{{old('name', $brand->name)}}" required maxlength="50" />
                        @error('name')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="col-12">
                        <h6>Brand's products</h6>
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brandProducts as $brandProduct)
                                <tr>
                                    <td>{{$brandProduct->name}}</td>
                                    <td class="text-end">{{$brandProduct->price}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-secondary" href="/products/{{$brandProduct->id}}" title="View"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-primary" href="/products/{{$brandProduct->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <form action="/products/{{$brandProduct->id}}" method="POST">
                                            @method("DELETE")
                                            @csrf
                                            <a class="btn btn-sm btn-danger" href="#!" onclick="deleteItem(this)" title="Delete"><i class="fa fa-times"></i></a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-sm btn-primary" href="/products/create?product_brand_id={{$brand->id}}">Add</a>
                        <hr />
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