@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post" action="/updateProfile" onsubmit="return validateForm()">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_name">Name</label>
                        <input id="user_account_name" name="name" class="form-control form-control-sm" value="{{old('name', $userAccount->name)}}" required maxlength="50" />
                        @error('name')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_email">Email</label>
                        <input id="user_account_email" name="email" class="form-control form-control-sm" value="{{old('email', $userAccount->email)}}" type="email" required maxlength="50" />
                        @error('email')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_password">Password</label>
                        <input id="user_account_password" name="password" class="form-control form-control-sm" type="password" placeholder="New password" maxlength="100" />
                        @error('password')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="mb-3 col-md-6 col-lg-4">
                        <label class="form-label" for="user_account_password2">Confirm password</label>
                        <input data-match="user_account_password" id="user_account_password2" name="password2" class="form-control form-control-sm" type="password" placeholder="New password" maxlength="100" />
                        @error('password')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                    <div class="col-12">
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