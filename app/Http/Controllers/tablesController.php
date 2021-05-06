<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use App\Floor;

class tablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::orderby('location_id','desc')->paginate(10);
        return view('dashboard.tables.index',compact('tables'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floors = Floor::all();
        return view('dashboard.tables.create',compact('floors'));
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
			'floor' => 'required'
		],[
			'name.required' => 'فیلد نام الزامی است.',
			'floor.required' => 'انتخاب طبقه الزامی است.'
		]);
		
		$tables = new Table();
		$data = $request -> all();
		
		$tables -> floor_id = $data['floor'];
		$tables -> name 	= $data['name'];
		$tables	-> save();
		return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
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
        $table = Table::find($id);
        $floors = Floor::all();
        return view('dashboard.tables.update',compact(['floors','table']));
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
			'floor' => 'required'
		],[
			'name.required' => 'فیلد نام الزامی است.',
			'floor.required' => 'انتخاب طبقه الزامی است.'
		]);
		
		$tables = Table::find($id);
		$data = $request -> all();
		
		$tables -> floor_id = $data['floor'];
		$tables -> name 	= $data['name'];
		$tables	-> save();
		return redirect()->route('tables.index')->with('success','عملیات موفقانه انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Table::find($id);
		$table->delete();
		return redirect()->route('tables.index')->with('success','عملیات موفقانه انجام شد.');
    }
}
