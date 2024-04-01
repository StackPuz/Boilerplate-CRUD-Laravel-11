@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/orderHeaders?ref={{urlencode($ref)}}">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_customer_id">Customer</label>
                        <select id="order_header_customer_id" name="customer_id" class="form-select form-select-sm" required>
                            @foreach ($customers as $customer)
                            <option value="{{$customer->id}}" {{old('customer_id') == $customer->id ? 'selected' : ''}}>{{$customer->name}}</option>
                            @endforeach
                        </select>
                        @error('customer_id')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="order_header_order_date">Order Date</label>
                        <input id="order_header_order_date" name="order_date" class="form-control form-control-sm" value="{{old('order_date')}}" data-type="date" autocomplete="off" required />
                        @error('order_date')<span class="text-danger">{{$message}}</span>@enderror
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