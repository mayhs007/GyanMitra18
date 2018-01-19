<?php

namespace App\Http\Controllers;


use Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Role;
use Session;
use Auth;

class UsersController extends Controller
{
    function index(){
        $users = User::all()->where('type', 'admin')->where('id', '<>', Auth::user()->id);
        return view('admin_pages.users.index')->with('users', $users);
    }
    function edit($user_id){
        $user = User::findOrFail($user_id);
        $roles = Role::all();
        return view('admin_pages.users.users.edit')->with('user', $user)->with('roles', $roles);        
    }
    public function create(){
        $user = new User();
        $roles = Role::all();
        return view('admin_pages.users.create')->with('user', $user)->with('roles', $roles);
    }
    public function store(UserRequest $request){
        $inputs = $request->all();
        $user = new User();
        $user->first_name = $inputs['first_name'];
        $user->last_name = $inputs['last_name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt(empty($inputs['password'])?'test':$inputs['password']);
        $user->type = 'admin';
        $user->level_of_study = 'admin';
        $user->save();
        $roles = Role::all()->whereIn('id', $inputs['roles']);
        foreach($roles as $role){
            $user->roles()->save($role);
        }
        Session::flash('info', 'The user was created!');
        return redirect()->route('admin::users.create');
    }
    function update(UserRequest $request, $user_id){
        $inputs = $request->all();
        $user = User::find($user_id);
        $user->update([
            'first_name' => $inputs['first_name'],
            'last_name' => $inputs['last_name'],
            'email' => $inputs['email'],            
            'password' => empty($inputs['password'])?$user->password:bcrypt($inputs['password']),
            'type' => 'admin'
        ]);
        $user->roles()->detach();
        $roles = Role::all()->whereIn('id', $inputs['roles']);
        foreach($roles as $role){
            $user->roles()->save($role);
        }
        Session::flash('info', 'The user was updated!');
        return redirect()->route('admin::users.index');
    }
    function destroy($user_id){
        $user = User::find($user_id);
        if($user->type == 'admin'){
            $user->roles()->detach();
            User::destroy($user_id);               
            Session::flash('info', 'The User was Removed!');
        }
        else{
            Session::flash('info', 'You cannot remove this user!');            
        }
        return redirect()->route('admin::users.index');
    }
}
