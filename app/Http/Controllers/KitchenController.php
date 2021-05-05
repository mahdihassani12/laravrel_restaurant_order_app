<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    public function getOrders(Request $request)
    {
        $orders = DB::table('inside_order as io')
            ->join('menu','menu.menu_id','=','io.menu_id')
            ->join('inside_order_total as iot','iot.order_id','=','io.total_id')
            ->join('location','location.location_id','=','iot.location_id')
            ->select('location.name','menu.name as menu_name','iot.identity','io.order_amount','io.order_id','io.total_id','iot.status')
            ->orderByDesc('io.order_id')
            ->get();
        if($request->ajax()){

            return response()->json(array('orders'=>$orders));
        }
        return view('Kitchen.index', compact('orders'));
    }


    public function sendOrders(Request $request)
    {
        $id = $request->get('id');
        $update = DB::table('inside_order_total')->where('order_id',$id)->update(['status'=>2]);
        if ($update){
            return true;
        }
        else{
            return false;
        }
    }
}
