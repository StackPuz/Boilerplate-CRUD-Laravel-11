@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/userAccounts?ref={{urlencode($ref)}}">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_name">Name</label>
                        <input id="user_account_name" name="name" class="form-control form-control-sm" value="{{old('name')}}" required maxlength="50" />
                        @error('name')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_email">Email</label>
                        <input id="user_account_email" name="email" class="form-control form-control-sm" value="{{old('email')}}" type="email" required maxlength="50" />
                        @error('email')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input id="user_account_active" name="active" class="form-check-input" type="checkbox" value="1" {{old('active') ? 'checked' : ''}} />
                        <label class="form-check-label" for="user_account_active">Active</label>
                        @error('active')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="col-12">
                        <h6>
                        </h6><label class="form-label">Roles</label>
                        @foreach ($roles as $role)
                        <div class="form-check">
                            <input id="user_role_role_id{{$role->id}}" name="role_id[]" class="form-check-input" type="checkbox" value="{{$role->id}}" />
                            <label class="form-check-label" for="user_role_role_id{{$role->id}}">{{$role->name}}</label>
                        </div>
                        @endforeach
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