<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills = Skill::all();
        return view('categories.create', compact('skills'));
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
            'name' => 'required|min:3|max:30',
            'spanish_name' => 'required|min:3|max:30',
            'picture' => 'required',
            'commission' => 'required',
            'status' => 'required',
            'skills' => 'required|array'
        ]);

        $category = Category::create($request->all());
        $category->skills()->sync($request->skills);

        return redirect()->route('categories.index')->with('message', 'Service Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $skills = Skill::all();
        return view('categories.edit', compact('category', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'spanish_name' => 'required|min:3|max:30',
            'picture' => 'required',
            'commission' => 'required',
            'status' => 'required',
            'skills' => 'required|array'
        ]);

        $category->update($request->all());
        $category->skills()->sync($request->skills);

        return redirect()->route('categories.index')->with('message', 'Service Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')->with('error', 'Service Delete Successfully!!');
            //code...
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')->with('error', 'Service not allow to delete.');
            //throw $th;
        }
    }
}
