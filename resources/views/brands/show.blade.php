@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="brand_id">Id</label>
                        <input readonly id="brand_id" name="id" class="form-control form-control-sm" value="{{$brand->id}}" type="number" required />
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="brand_name">Name</label>
                        <input readonly id="brand_name" name="name" class="form-control form-control-sm" value="{{$brand->name}}" required maxlength="50" />
                    </div>
                    <div class="col-12">
                        <h6>Brand's products</h6>
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brandProducts as $brandProduct)
                                <tr>
                                    <td>{{$brandProduct->name}}</td>
                                    <td class="text-end">{{$brandProduct->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-sm btn-secondary" href="{{$ref}}">Back</a>
                        <a class="btn btn-sm btn-primary" href="/brands/{{$brand->id}}/edit?ref={{urlencode($ref)}}">Edit</a>
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