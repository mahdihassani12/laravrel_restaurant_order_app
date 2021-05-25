<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use App\OutsideModel;
use Carbon\Carbon;
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
        $inTotal = count(InsideOrder::all());
        $inFoodsTotal = DB::table('inside_order')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','غذا')
            ->select('order_id')
            ->get();

        $inDrinksTotal = DB::table('inside_order')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','نوشیدنی')
            ->select('order_id')
            ->get();
        $inIcecreameTotal = DB::table('inside_order')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','بستنی')
            ->select('order_id')
            ->get();

        $inFTo = count($inFoodsTotal);
        $inDTo = count($inDrinksTotal);
        $inICTo = count($inIcecreameTotal);

        $outTotal = count(OutsideModel::all());
        $outFoodsTotal = DB::table('outside_order')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','غذا')
            ->select('order_id')
            ->get();

        $outDrinksTotal = DB::table('outside_order')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','نوشیدنی')
            ->select('order_id')
            ->get();
        $outIcecreameTotal = DB::table('outside_order')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','بستنی')
            ->select('order_id')
            ->get();


        $outFto = count($outFoodsTotal);
        $outDTo = count($outDrinksTotal);
        $outICTo = count($outIcecreameTotal);




        $year = Carbon::now()->year;

        $arr = array();
        $arr2 = array();
        for ($i = 1; $i <= 9; $i++) {

            $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-0" . $i . "%")->sum("payment");
            $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-0" . $i . "%")->sum("payment");

        }
        //it is for student payment
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-10%")->sum("payment");
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-11%")->sum("payment");
        $arr[] = \DB::table("inside_order_total")->where("created_at", "like", $year . "-12%")->sum("payment");

        //it is for student payment
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-10%")->sum("payment");
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-11%")->sum("payment");
        $arr2[] = \DB::table("outside_order_total")->where("created_at", "like", $year . "-12%")->sum("payment");



        $inFoodsTotal = DB::table('inside_order_total as iot')
            ->join('inside_order','inside_order.total_id','=','iot.order_id')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','غذا')
            ->select('order_id')
            ->whereYear("iot.created_at", "like", $year)
            ->sum('payment');

        $inDrinksTotal = DB::table('inside_order_total as iot')
            ->join('inside_order','inside_order.total_id','=','iot.order_id')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','نوشیدنی')
            ->whereYear("iot.created_at", "like", $year)
            ->sum('payment');
        $inIcecreameTotal = DB::table('inside_order_total as iot')
            ->join('inside_order','inside_order.total_id','=','iot.order_id')
            ->join('menu','menu.menu_id','=','inside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','بستنی')
            ->whereYear("iot.created_at", "like", $year)
            ->sum('payment');



        $outFoodsTotal = DB::table('outside_order_total as ost')
            ->join('outside_order','outside_order.total_id','=','ost.order_id')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','غذا')
            ->whereYear("ost.created_at", "like", $year)
            ->sum('payment');

        $outDrinksTotal = DB::table('outside_order_total as ost')
            ->join('outside_order','outside_order.total_id','=','ost.order_id')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','نوشیدنی')
            ->whereYear("ost.created_at", "like", $year)
            ->sum('payment');

        $outIcecreameTotal = DB::table('outside_order_total as ost')
            ->join('outside_order','outside_order.total_id','=','ost.order_id')
            ->join('menu','menu.menu_id','=','outside_order.menu_id')
            ->join('categories','categories.category_id','=','menu.category_id')
            ->where('categories.name','=','بستنی')
            ->whereYear("ost.created_at", "like", $year)
            ->sum('payment');

        $arr3 = array_map(function () {
            return array_sum(func_get_args());
        }, $arr, $arr2);


        $Fto = ($outFoodsTotal+$inFoodsTotal);
        $DTo = ($outDrinksTotal+$inDrinksTotal);
        $ICTo = ($outIcecreameTotal+$inIcecreameTotal);

        return view('dashboard.welcome',compact('inTotal','inFTo','inDTo','inICTo','outTotal','outFto','outDTo','outICTo',
            'Fto','DTo','ICTo','arr3'));
    }

    /*
    *   Kitchen Dashboard
    */ 
    public function kitchenDashboard()
    {
        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order','inside_order.total_id','=','iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name','iot.order_id','identity','iot.status')
            ->orderByDesc('iot.order_id')
            ->groupBy('location.name','iot.order_id','identity')
            ->get();
        return view('Kitchen.insideOrder.list',compact('orders'));
    }

    /*
    *   Accountant Dashboard
    */ 
    public function accountantDashboard()
    {
        return view('Payment.welcome');
    }

    /*
    *   Order Dashboard
    */ 
    public function orderDashboard()
    {		         
		$food = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
			->where('categories.name','LIKE', '%غذا%')
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
