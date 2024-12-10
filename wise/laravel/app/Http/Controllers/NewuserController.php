<?php

namespace App\Http\Controllers;

use App\Newuser;
use Illuminate\Http\Request;

class NewuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/admincontrol/userreg');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user' => 'required',
            'email' => 'required',
            'user' => 'required',
            'password' => 'required',
            'user' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newuser  $newuser
     * @return \Illuminate\Http\Response
     */
    public function show(Newuser $newuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newuser  $newuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Newuser $newuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newuser  $newuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newuser $newuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newuser  $newuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newuser $newuser)
    {
        //
    }
}
