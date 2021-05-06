<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderby('category_id','desc')->get();
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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
			'name' => 'required'
		],[
			'name.required' => 'نام دسته فیلد الزامی است.'
		]);
		
		$categories = new Category();
		$data = $request -> all();
		
		$categories -> name = $data['name'];
		$categories -> save();
		
		return redirect()->route('categories.index')->with('success','عملیات موفقانه انجام شد.');
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
		return view('dashboard.categories.update',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
			'name' => 'required'
		],[
			'name.required' => 'نام دسته فیلد الزامی است.'
		]);
		
		$categories = Category::find($id);
		$data = $request -> all();
		
		$categories -> name = $data['name'];
		$categories -> save();
		
		return redirect()->route('categories.index')->with('success','عملیات موفقانه انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::find($id);
		$categories -> delete();
		return redirect()->route('categories.index')->with('success','عملیات موفقانه انجام شد.');
    }
}
