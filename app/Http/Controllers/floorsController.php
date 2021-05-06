<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Floor;

class floorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::orderby('floor_id','desc')->get();
        return view('dashboard.floors.index',compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.floors.create');
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
            'floor_name' => 'required'
        ],
		[
			'floor_name.required' => 'نام طبقه فیلد الزامی است.'
		]);
		
		$data = $request -> all();
		$floor = new Floor();
		
		$floor -> floor_name = $data['floor_name'];
		$floor -> save();
		
		return redirect()->route('floors.index')->with('success','عملیات موفقانه انجام شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $floor = Floor::find($id);
        return view('dashboard.floors.update',compact('floor'));
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
            'floor_name' => 'required'
        ],
        [
            'floor_name.required' => 'نام طبقه فیلد الزامی است.'
        ]);
        
        $data = $request -> all();
        $floor = Floor::find($id);
        
        $floor -> floor_name = $data['floor_name'];
        $floor -> save();
        
        return redirect()->route('floors.index')->with('success','عملیات موفقانه انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $floor = Floor::find($id);
        $floor -> delete();
        return redirect()->route('floors.index')->with('success','عملیات موفقانه انجام شد.');
    }
}
