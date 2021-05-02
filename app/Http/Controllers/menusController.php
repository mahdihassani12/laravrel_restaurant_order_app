<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Category;
use DB;

class menusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$food = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->where('categories.name','LIKE', '%فست فوت%')
            ->select('menu.*')
            ->paginate(10,['*'],'food');
         
        $drink = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->where('categories.name','LIKE', '%نوشیدنی%')
            ->select('menu.*')
            ->paginate(10,['*'],'drink');
        
        $icecream = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->where('categories.name','LIKE', '%بستنی%')
            ->select('menu.*')
            ->paginate(10,['*'],'iceCream');

        return view('dashboard.menus.index',compact(['food','drink','icecream']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$categories = Category::all();
        return view('dashboard.menus.create',compact('categories'));
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
			'price' => 'required|numeric',
			'category' => 'required'
		],[
			'name.required' => 'فیلد نام الزامی است.',
			'price.required' => 'فیلد قیمت الزامی است.',
			'price.numeric' => 'قیمت را به عدد وارد نمایید',
			'category.required' => 'انتخاب دسته الزامی است.'
		]);
		
		$data = $request->all();
		$menus = new Menu();
		
		$menus -> name = $data['name'];
		$menus -> price = $data['price'];
		$menus -> category_id = $data['category'];
		
		$menus -> save();
		
		return redirect()->route('menus.index')->with('success','عملیات موفقانه انجام شد');
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
		$menu = Menu::find($id);
		$categories = Category::all();
        return view('dashboard.menus.update',compact(['categories','menu']));
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
			'name' => 'required',
			'price' => 'required|numeric',
			'category' => 'required'
		],[
			'name.required' => 'فیلد نام الزامی است.',
			'price.required' => 'فیلد قیمت الزامی است.',
			'price.numeric' => 'قیمت را به عدد وارد نمایید',
			'category.required' => 'انتخاب دسته الزامی است.'
		]);
		
		$data = $request->all();
		$menus = Menu::find($id);
		
		$menus -> name = $data['name'];
		$menus -> price = $data['price'];
		$menus -> category_id = $data['category'];
		
		$menus -> save();
		
		return redirect()->route('menus.index')->with('success','عملیات موفقانه انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menus = Menu::find($id);
		$menus -> delete();
		return redirect()->route('menus.index')->with('success','عملیات موفقانه انجام شد');
    }
}
