<?php

namespace App\Http\Controllers;

use App\InsideOrder;
use App\InsideOrderTotal;
use App\Notifications\newOrderNotification;
use App\OutsideModel;
use App\OutsideOrderTotal;
use App\Table;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OutsideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = OutsideOrderTotal::orderby('order_id','desc')->paginate(10);
        return view('order.outsideOrder.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $tables = Table::all();
        return view('order.outsideOrder.create',compact(['food','drink','icecream','tables']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        try{

            DB::beginTransaction();
            $request->validate([
                'menu_id' => 'required',
                'order_amount' => 'required',
                'order_price'  => 'required',
                'total'     => 'required',
                'name'     => 'required',
                'phone_num'     => 'required',
                'address'     => 'required',
                'payment_amount'     => 'required',
            ],[
                'menu_id.required'  => 'افزودن مینوی غذایی الزامی است.',
                'order_amount.required' => 'تعداد سفارشات الزامی است.',
                'total.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'order_price.required' => 'هیچ مقدار پولی وارد نشده است.',
                'name.required' => 'نام الزامی است.',
                'phone_num.required' => 'شماره تماس الزامی است.',
                'address.required' => 'آدرس الزامی است.',
                'payment_amount.required' => 'مقدار پرداخت الزامی است.',
            ]);


            $total = new OutsideOrderTotal();
            $data = $request -> all();
            $user = User::all();
            $total -> name = $data['name'];
            $total -> phone = $data['phone_num'];
            $total -> address = $data['address'];
            $total -> total_payment = $data['total'];
            $total -> payment = $data['payment_amount'];
            $total -> discount = $data['discount'];
            $total -> transport_price = $data['transport_fees'];
            $total -> identity =\random_int(100000, 999999);
            Notification::send($user, new newOrderNotification('سفارش جدید دارید!'));
            $total -> save();

            foreach ($request->input('menu_id') as $item => $value) {

                $order = new OutsideModel();
                $order -> total_id = $total->order_id;
                $order -> menu_id = $data['menu_id'][$item];
                $order -> order_amount = $data['order_amount'][$item];
                $order -> price = $data['order_price'][$item];
                $order -> save();

            }
            DB::commit();
        }

        catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
    }



    public function loadData($id){
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

        $tables = Table::all();

        $orders = DB::table('outside_order_total as out')
            ->join('outside_order as ot','ot.total_id','=','out.order_id')
            ->join('menu', 'menu.menu_id', '=', 'ot.menu_id')
            ->join('categories', 'categories.category_id', '=', 'menu.category_id')
            ->select( 'menu.name as menu_name',  'ot.order_amount', 'out.order_id', 'ot.total_id','categories.name','out.status','ot.price','ot.menu_id')
            ->where('out.order_id','=',$id)
            ->get();
        $t_orders = OutsideOrderTotal::find($id);

        return view('order.outsideOrder.edit',compact(['food','drink','icecream','tables','t_orders','orders']));

    }

    public function updateOutsideOrder(Request $request,$id){
//        dd($request->all());
        try{

            DB::beginTransaction();
            $request->validate([
                'menu_id_field' => 'required',
                'order_amount_field' => 'required',
                'order_price_field'  => 'required',
                'total'     => 'required',
                'name'     => 'required',
                'phone_num'     => 'required',
                'address'     => 'required',
                'payment_amount'     => 'required',
            ],[
                'menu_id_field.required'  => 'افزودن مینوی غذایی الزامی است.',
                'order_amount_field.required' => 'تعداد سفارشات الزامی است.',
                'total.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'order_price_field.required' => 'هیچ مقدار پولی وارد نشده است.',
                'name.required' => 'نام الزامی است.',
                'phone_num.required' => 'شماره تماس الزامی است.',
                'address.required' => 'آدرس الزامی است.',
                'payment_amount.required' => 'مقدار پرداخت الزامی است.',
            ]);


            $total = OutsideOrderTotal::find($id);
            $data = $request -> all();

            $total -> name = $data['name'];
            $total -> phone = $data['phone_num'];
            $total -> address = $data['address'];
            $total -> total_payment = $data['total_payment'];
            $total -> payment = $data['payment_amount'];
            $total -> discount = $data['discount'];
            $total -> transport_price = $data['transport_fees'];
            $total -> identity =$data['identity'];
            $total -> save();
            DB::table('outside_order')->where('total_id',$id)->delete();
            foreach ($request->input('menu_id_field') as $item => $value) {

                $order = new OutsideModel();
                $order -> total_id = $total->order_id;
                $order -> menu_id = $data['menu_id_field'][$item];
                $order -> order_amount = $data['order_amount_field'][$item];
                $order -> price = $data['order_price_field'][$item];
                $order -> save();

            }
            DB::commit();
        }

        catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
    }
    public function destroy($id)
    {
        //
    }




}
