<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Menu;

class HomeController extends Controller
{
    

    /*
    *   Admin Dashboard
    */ 
    public function index()
    {
        return view('dashboard.welcome');
    }

    /*
    *   Kitchen Dashboard
    */ 
    public function kitchenDashboard()
    {
        return view('Kitchen.welcome');
    }

    /*
    *   Accountant Dashboard
    */ 
    public function accountantDashboard()
    {
        echo "accountantDashboard";
    }

    /*
    *   Order Dashboard
    */ 
    public function orderDashboard()
    {		         
		$food = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
			->where('categories.name','LIKE', '%فست فوت%')
			->select('menu.*')
            ->get(); 
		 
		$drink = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
			->where('categories.name','LIKE', '%نوشیدنی%')
			->select('menu.*')
            ->get();
		
		$icecream = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
			->where('categories.name','LIKE', '%بستنی%')
			->select('menu.*')
            ->get();

        return view('order.welcome',compact(['food','drink','icecream']));
    }

}
