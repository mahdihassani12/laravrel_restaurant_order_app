<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use App\InsideOrderTotal;
use App\OutsideOrderTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    public function getOrders(Request $request)
    {
//        $orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order', 'inside_order.total_id', '=', 'iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name', 'iot.order_id', 'identity', 'iot.status')
            ->orderByDesc('iot.order_id')
            ->where('iot.status', '=', '1')
            ->groupBy('location.name', 'iot.order_id', 'identity')
            ->get();

        foreach ($orders as $order) {

            $insideOrders = DB::table('inside_order as io')
                ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                ->join('inside_order_total as iot', 'iot.order_id', '=', 'io.total_id')
                ->select('menu.name as menu_name', 'io.order_amount', 'io.order_id', 'io.total_id', 'categories.name', 'iot.status',
                    'iot.order_id', 'iot.identity')
                ->where('total_id', $order->order_id)
                ->get();

        }

        if ($request->ajax()) {

            return response()->json(array('orders' => $orders, 'insideOrders' => $insideOrders));
        }
        $user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get();
        return view('Kitchen.insideOrder.list', compact('orders', 'user'));
    }


    public function sendOrders(Request $request)
    {
        $id = $request->get('id');
        $order_id = $request->get('order_id');
//
//        if ($order_id != null) {
//            $update = DB::table('inside_order_total')->where('order_id', $order_id)->update(['status' => 2]);
//            if ($update) {
//                $orders = InsideOrderTotal::where('order_id', $request->order_id)->get();
//                return view('Kitchen.insideOrder.print', compact('orders'));
//            } else {
//                return false;
//            }
//        }
//        else {
            $update = DB::table('inside_order_total')->where('order_id', $id)->update(['status' => 2]);
            if ($update) {
                return true;
            } else {
                return false;
            }
//        }

    }

    public function kitchenSearch(Request $request)
    {

        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order', 'inside_order.total_id', '=', 'iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name', 'iot.order_id', 'identity', 'iot.status')
            ->orderByDesc('iot.order_id')
            ->groupBy('location.name', 'iot.order_id', 'identity')
            ->where('iot.status', '=', '1')
            ->get();

        return view('Kitchen.insideOrder.search', compact(['orders']));
    }


    public function getOutsideOrders(Request $request)
    {
//        $orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        $orders = DB::table('outside_order_total as iot')
            ->join('outside_order', 'outside_order.total_id', '=', 'iot.order_id')
            ->select('name', 'identity', 'iot.order_id', 'status')
            ->orderByDesc('iot.order_id')
            ->where('iot.status', '=', '1')
            ->groupBy('name', 'identity', 'iot.order_id', 'status')
            ->get();
        foreach ($orders as $order) {

            $insideOrders = DB::table('outside_order as io')
                ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                ->join('outside_order_total as iot', 'iot.order_id', '=', 'io.total_id')
                ->select('menu.name as menu_name', 'io.order_amount', 'iot.order_id', 'io.total_id', 'categories.name', 'iot.status')
                ->where('total_id', $order->order_id)
                ->get();

        }

        if ($request->ajax()) {

            return response()->json(array('orders' => $orders, 'insideOrders' => $insideOrders));
        }
        $user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get();
        return view('Kitchen.outsideOrder.list', compact('orders', 'user'));
    }


    public function sendOutsideOrders(Request $request)
    {

        $id = $request->get('id');
        $order_id = $request->get('order_id');

        if ($order_id != null) {
            $update = DB::table('outside_order_total')->where('order_id', $order_id)->update(['status' => 2]);
            if ($update) {

                $orders = OutsideOrderTotal::where('order_id', $request->order_id)->get();
                return view('Kitchen.outsideOrder.print', compact('orders'));
            } else {
                return false;
            }
        } else {
            $update = DB::table('outside_order_total')->where('order_id', $id)->update(['status' => 2]);
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function kitchenOutsideSearch(Request $request)
    {

        $orders = DB::table('outside_order_total as iot')
            ->join('outside_order', 'outside_order.total_id', '=', 'iot.order_id')
            ->select('name', 'identity', 'iot.order_id', 'status')
            ->orderByDesc('iot.order_id')
            ->groupBy('name', 'identity', 'iot.order_id', 'status')
            ->where('iot.status', '=', '1')
            ->get();


        return view('Kitchen.outsideOrder.search', compact(['orders']));


    }


    //get notification
    public function getNotification()
    {
        $count = count($user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get());

        return response([
            'count' => $count,

        ]);
    }


    //get inside order send
    public function getSendOrders()
    {
        $orders = DB::table('inside_order_total as iot')
            ->join('inside_order', 'inside_order.total_id', '=', 'iot.order_id')
            ->join('location', 'location.location_id', '=', 'iot.location_id')
            ->select('location.name', 'iot.order_id', 'identity', 'iot.status')
            ->orderByDesc('iot.order_id')
            ->where('iot.status', '=', '2')
            ->groupBy('location.name', 'iot.order_id', 'identity')
            ->get();
        $user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get();
        return view('Kitchen.insideOrder.insideOrderSendList', compact(['orders', 'user']));
    }

    //get outside order send
    public function getOutsideSendOrders()
    {
        $orders = DB::table('outside_order_total as iot')
            ->join('outside_order', 'outside_order.total_id', '=', 'iot.order_id')
            ->select('name', 'identity', 'iot.order_id', 'status')
            ->orderByDesc('iot.order_id')
            ->groupBy('name', 'identity', 'iot.order_id', 'status')
            ->where('iot.status', '=', '2')
            ->get();
        $user = DB::table('notifications')->where('notifiable_id', Auth::user()->user_id)->get();
        return view('Kitchen.outsideOrder.outsideOrderSendList', compact(['orders', 'user']));
    }


    //print
    public function sendOrdersForPrint(Request $request)
    {

        $orders = InsideOrderTotal::where('status', '1')->get();
        $date = \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::now())->format("Y-m-d H:i:s");
//        dd($orders);
        if (count($orders)>0){
            $update = DB::table('inside_order_total')->where('status', 1)->update(['status' => 2]);
            return view('Kitchen.insideOrder.autoPrint', compact('orders','date'));
        }



    }

    public function sendOutOrdersForPrint(Request $request)
    {
        $orders = OutsideOrderTotal::where('status', '1')->get();
        $date = \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::now())->format("Y-m-d H:i:s");

        if (count($orders)>0){
            $update = DB::table('outside_order_total')->where('status', 1)->update(['status' => 2]);
            return view('Kitchen.outsideOrder.autoPrint', compact('orders','date'));
        }



    }


}
