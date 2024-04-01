<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Util;
use App\Models\UserAccount;

class SystemController extends Controller {

    public function home()
    {
        return view('home');
    }

    public function profile()
    {
        $id = Auth::id();
        $userAccount = UserAccount::query()
            ->select('UserAccount.name', 'UserAccount.email')
            ->where('UserAccount.id', $id)
            ->first();
        return view('profile', [ 'userAccount' => $userAccount ]);
    }

    public function updateProfile()
    {
        $this->validate(request(), [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'password' => 'max:100'
        ]);
        $id = Auth::id();
        $userAccount = UserAccount::find($id);
        UserAccount::find($id)->update([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => request()->input('password') ? Hash::make(request()->input('password')) : $userAccount->password
        ]);
        return redirect('/home');
    }

    public function stack() {
        return 'Laravel 11 + MySQL';
    }
}