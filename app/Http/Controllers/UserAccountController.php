<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Util;
use App\Models\UserAccount;
use App\Models\UserRole;

class UserAccountController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'UserAccount.id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = UserAccount::query()
            ->select('UserAccount.id', 'UserAccount.name', 'UserAccount.email', 'UserAccount.active')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $userAccounts = $query->paginate($size);
        return view('userAccounts.index', ['userAccounts' => $userAccounts]);
    }

    public function create()
    {
        $roles = DB::table('Role')
            ->select('Role.id', 'Role.name')
            ->get();
        return view('userAccounts.create', ['ref' => Util::getRef('/userAccounts'), 'roles' => $roles]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'unique:UserAccount,name|required|max:50',
            'email' => 'unique:UserAccount,email|required|max:50',
        ]);
        $token = Str::random(40);
        $password = Hash::make(Str::random(10));
        $userAccount = UserAccount::create([
            'password_reset_token' => $token,
            'password' => $password,
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'active' => Util::getRaw(request()->input('active') == null ? false : request()->input('active'))
        ]);
        $roles = request()->input('role_id');
        if ($roles) {
            foreach ($roles as $role) {
                UserRole::create([
                    'user_id' => $userAccount->id,
                    'role_id' => $role
                ]);
            }
        }
        Util::sentMail('WELCOME', $userAccount->email, $token, $userAccount->name);
        return redirect(request()->query->get('ref'));
    }

    public function show($id)
    {
        $userAccount = UserAccount::query()
            ->select('UserAccount.id', 'UserAccount.name', 'UserAccount.email', 'UserAccount.active')
            ->where('UserAccount.id', $id)
            ->first();
        $userAccountUserRoles = DB::table('UserAccount')
            ->join('UserRole', 'UserAccount.id', 'UserRole.user_id')
            ->join('Role', 'UserRole.role_id', 'Role.id')
            ->select('Role.name as role_name')
            ->where('UserAccount.id', $id)
            ->get();
        return view('userAccounts.show', ['userAccount' => $userAccount, 'ref' => Util::getRef('/userAccounts'), 'userAccountUserRoles' => $userAccountUserRoles]);
    }

    public function edit($id)
    {
        $userAccount = UserAccount::query()
            ->select('UserAccount.id', 'UserAccount.name', 'UserAccount.email', 'UserAccount.active')
            ->where('UserAccount.id', $id)
            ->first();
        $userAccountUserRoles = DB::table('UserAccount')
            ->join('UserRole', 'UserAccount.id', 'UserRole.user_id')
            ->select('UserRole.role_id')
            ->where('UserAccount.id', $id)
            ->get();
        $roles = DB::table('Role')
            ->select('Role.id', 'Role.name')
            ->get();
        return view('userAccounts.edit', ['userAccount' => $userAccount, 'ref' => Util::getRef('/userAccounts'), 'userAccountUserRoles' => $userAccountUserRoles, 'roles' => $roles]);
    }

    public function update($id)
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'password' => 'max:100',
        ]);
        $userAccount = UserAccount::find($id);
        UserAccount::find($id)->update([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => request()->input('password') ? Hash::make(request()->input('password')) : $userAccount->password,
            'active' => Util::getRaw(request()->input('active') == null ? false : request()->input('active'))
        ]);
        DB::table('UserRole')
            ->where('UserRole.user_id', $id)
            ->delete();
        $roles = request()->input('role_id');
        if ($roles) {
            foreach ($roles as $role) {
                UserRole::create([
                    'user_id' => $id,
                    'role_id' => $role
                ]);
            }
        }
        return redirect(request()->query->get('ref'));
    }

    public function destroy($id)
    {
        UserAccount::find($id)->delete();
        return back();
    }
}