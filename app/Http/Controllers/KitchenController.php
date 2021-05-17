<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use App\InsideOrderTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    public function getOrders(Request $request)
    {
//        $orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order','inside_order.total_id','=','iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name','iot.order_id','identity','iot.status')
            ->orderByDesc('iot.order_id')
            ->groupBy('location.name','iot.order_id','identity')
            ->get();
        foreach ($orders as $order) {

            $insideOrders = DB::table('inside_order as io')
                ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                ->join('inside_order_total as iot','iot.order_id','=','io.total_id')
                ->select( 'menu.name as menu_name',  'io.order_amount', 'io.order_id', 'io.total_id','categories.name','iot.status','iot.order_id','iot.identity')
                ->where('total_id', $order->order_id)
                ->get();

        }

        if ($request->ajax()) {

            return response()->json(array('orders' => $orders,'insideOrders'=>$insideOrders));
        }
        return view('Kitchen.insideOrder.list', compact('orders'));
    }


    public function sendOrders(Request $request)
    {
        $id = $request->get('id');
        $update = DB::table('inside_order_total')->where('order_id', $id)->update(['status' => 2]);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function kitchenSearch(Request $request)
    {

        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order', 'inside_order.total_id', '=', 'iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->orderByDesc('iot.order_id')
            ->groupBy('iot.order_id','identity','location.name')
            ->get();


        return view('Kitchen.insideOrder.search', compact(['orders']));
    }


        public function getOutsideOrders(Request $request)
    {
//        $orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        $orders = DB::table('outside_order_total as iot')
            ->join('outside_order','outside_order.total_id','=','iot.order_id')
            ->select('name','identity','iot.order_id','status')
            ->orderByDesc('iot.order_id')
            ->groupBy('name','identity','iot.order_id','status')
            ->get();
        foreach ($orders as $order) {

            $insideOrders = DB::table('outside_order as io')
                ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                ->join('outside_order_total as iot','iot.order_id','=','io.total_id')
                ->select( 'menu.name as menu_name',  'io.order_amount', 'iot.order_id', 'io.total_id','categories.name','iot.status')
                ->where('total_id', $order->order_id)
                ->get();

        }

        if ($request->ajax()) {

            return response()->json(array('orders' => $orders,'insideOrders'=>$insideOrders));
        }
        return view('Kitchen.outsideOrder.list', compact('orders'));
    }


        public function sendOutsideOrders(Request $request)
    {
        $id = $request->get('id');

        $update = DB::table('outside_order_total')->where('order_id', $id)->update(['status' => 2]);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

        public function kitchenOutsideSearch(Request $request)
    {

        $orders = DB::table('outside_order_total as iot')
            ->join('outside_order','outside_order.total_id','=','iot.order_id')
            ->select('name','identity','iot.order_id','status')
            ->orderByDesc('iot.order_id')
            ->groupBy('name','identity','iot.order_id','status')
            ->get();


        return view('Kitchen.outsideOrder.search',compact(['orders']));



    }
}
