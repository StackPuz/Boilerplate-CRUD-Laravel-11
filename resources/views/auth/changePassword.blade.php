@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="center-container">
                <div class="d-flex justify-content-center">
                    <div class="card card-width p-0">
                        <div class="card-header">
                            <h3>Change Password</h3>
                        </div>
                        <div class="card-body">
                            <i class="login fa fa-user-circle"></i>
                            <form method="post" action="/changePassword/{{$token}}" onsubmit="return validateForm()">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="user_account_password">Password</label>
                                        <input id="user_account_password" name="password" class="form-control form-control-sm" value="{{old('password')}}" type="password" required maxlength="100" />
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="user_account_password2">Confirm password</label>
                                        <input data-match="user_account_password" id="user_account_password2" name="password2" class="form-control form-control-sm" value="{{old('password')}}" type="password" required maxlength="100" />
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-secondary w-100">Change Password</button>
                                    </div>
                                </div>
                            </form>
                            @if(isset($success))<span class="text-success">Change password done</span>@endif
                            @if(isset($error))<span class="text-danger">Token not found!</span>@endif
                        </div>
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