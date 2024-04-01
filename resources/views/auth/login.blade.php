@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="center-container">
                <div class="d-flex justify-content-center">
                    <div class="card card-width p-0">
                        <div class="card-header">
                            <h3>Login</h3>
                        </div>
                        <div class="card-body">
                            <i class="login fa fa-user-circle"></i>
                            <form method="post" action="/login">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="user_account_name">User Name</label>
                                        <input id="user_account_name" name="name" class="form-control form-control-sm" value="{{old('name')}}" required maxlength="50" />
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="user_account_password">Password</label>
                                        <input id="user_account_password" name="password" class="form-control form-control-sm" value="{{old('password')}}" type="password" required maxlength="100" />
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-secondary w-100">Login</button>
                                        <a href="/resetPassword">Forgot Password?</a>
                                    </div>
                                </div>
                            </form>
                            @foreach($errors->all() as $message )<span class="text-danger">{{$message}}</span>@endforeach
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