<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get(); 
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:30',      
            'last_name' => 'required|min:3|max:30',    
            'email' => 'required|min:3|max:30',
            'is_admin' => 'required',
            'status' => 'required'
        ]);
        User::create($request->all());
        return redirect()->route('users.index')->with('message', 'User Added Successfully!!');
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:30',      
            'last_name' => 'required|min:3|max:30',    
            'email' => 'required|min:3|max:150',
            'is_admin' => 'required',
            'status' => 'required'
        ]);
  
        $user->update($request->all());
        return redirect()->route('users.index')->with('message', 'User Updated Successfully!!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('error', 'User Delete Successfully!!');
    }
}
