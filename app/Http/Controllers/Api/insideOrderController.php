<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\newOrderNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\InsideOrder;
use App\InsideOrderTotal;
use App\Table;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class insideOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = InsideOrderTotal::orderby('order_id', 'desc')->paginate(10);
       return response([
           'data'=>$orders
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {

        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.menu_id','menu.name','menu.price')
            ->where('menu.category_id', '=', 1)
            ->get();
        $categories = DB::table('categories')
            ->select('category_id','name')
            ->get();
        $tables = DB::table('location')
            ->select('location_id','name')->get();
        return response([
            'menu'=>$menu,
            'categories'=>$categories,
            'table'=>$tables
        ]);
    }

    public function getMenu(Request $request)
    {
        $id = $request->get('id');
        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.*')
            ->where('menu.category_id', '=', $id)
            ->get();
        return response($menu);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        try {

            DB::beginTransaction();
            $request->validate([
                'menu_id' => 'required',
                'order_amount' => 'required',
                'order_price' => 'required',
                'total' => 'required',
                'table_order' => 'required'
            ], [
                'menu_id.required' => 'افزودن مینوی غذایی الزامی است.',
                'order_amount.required' => 'تعداد سفارشات الزامی است.',
                'total.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'table_order.required' => 'انتخاب میز الزامی است',
                'order_price.required' => 'هیچ مقدار پولی وارد نشده است.',
            ]);


            $total = new InsideOrderTotal();
            $data = $request->all();
            $user = User::all();
            $total->location_id = $data['table_order'];
            $total->total = $data['total'];
            $total->identity = \random_int(100000, 999999);
            Notification::send($user, new newOrderNotification('سفارش جدید دارید!'));
            $total->save();

            foreach ($request->input('menu_id') as $item => $value) {

                $order = new InsideOrder();
                $order->total_id = $total->order_id;
                $order->menu_id = $data['menu_id'][$item];
                $order->order_amount = $data['order_amount'][$item];
                $order->price = $data['order_price'][$item];


                $order->save();

            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errors', 'error');
        }
        $response = array(
            'status' => 'success',
            'msg' => 'موفقانه انجام شد!',
        );
        return response($response);
    }



    public function loadInsideData($id)
    {
        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.*')
            ->where('menu.category_id', '=', 1)
            ->get();
        $categories = DB::table('categories')
            ->select('*')
            ->get();
        $tables = Table::all();

        $orders = DB::table('inside_order_total as in')
            ->join('inside_order as ot', 'ot.total_id', '=', 'in.order_id')
            ->join('menu', 'menu.menu_id', '=', 'ot.menu_id')
            ->join('categories', 'categories.category_id', '=', 'menu.category_id')
            ->select('menu.name as menu_name', 'ot.order_amount', 'in.order_id', 'ot.total_id', 'categories.name', 'in.status', 'ot.price', 'ot.menu_id')
            ->where('in.order_id', '=', $id)
            ->get();
        $t_orders = InsideOrderTotal::find($id);

        return response([
            'categories'=>$categories,
            'menu'=>$menu,
            'tables'=>$tables,
            't_orders'=>$t_orders,
            'orders'=>$orders
        ]);

    }

    public function updateInsideOrder(Request $request, $id)
    {

        try {

            DB::beginTransaction();
            $request->validate([
                'menu_id_field' => 'required',
                'order_amount_field' => 'required',
                'order_price_field' => 'required',
                'total_payment' => 'required',
                'table_name' => 'required'
            ], [
                'menu_id_field.required' => 'افزودن مینوی غذایی الزامی است.',
                'order_amount_field.required' => 'تعداد سفارشات الزامی است.',
                'order_price_field.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'table_name.required' => 'انتخاب میز الزامی است',
                'total_payment.required' => 'هیچ مقدار پولی وارد نشده است.',
            ]);


            $total = InsideOrderTotal::find($id);
            $data = $request->all();

            $total->location_id = $data['table_name'];
            $total->total = $data['total_payment'];
            $total->identity = $data['identity'];
            $total->save();
            DB::table('inside_order')->where('total_id', $id)->delete();
            foreach ($request->input('menu_id_field') as $item => $value) {

                $order = new InsideOrder();
                $order->total_id = $total->order_id;
                $order->menu_id = $data['menu_id_field'][$item];
                $order->order_amount = $data['order_amount_field'][$item];
                $order->price = $data['order_price_field'][$item];
                $order->save();

            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errors', 'error');
        }
        return redirect()->back()->with('success', 'عملیات موفقانه انجام شد.');
    }
}
