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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    public function paymentInsideList()
    {
        $orders = InsideOrderTotal::where('payment','=',0)->where('status','2')->paginate(10);
        return view('Payment.insidePayment.index',compact('orders'));
    }


    public function paymentInsideCreate(Request $request)
    {

        try{

            DB::beginTransaction();
            DB::table('inside_order_total')->where('order_id',$request->order_id)->update([
                'payment'=>$request->pay,
                'discount'=>$request->discount,
                'status'=>3
            ]);
            DB::commit();
        }

        catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        if ($request->print_in!=null){
            $orders = InsideOrderTotal::where('order_id',$request->order_id)->get();
            return view('Payment.insidePayment.print',compact('orders'))->with('success','عملیات موفقانه انجام شد.');
        }
        else{
            return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
        }

    }

    public function paymentInsideUpdate(Request $request)
    {
        try{


            DB::beginTransaction();
            if ($request->discount!=$request->old_discount && $request->pay!=0){
                DB::table('inside_order_total')->where('order_id',$request->order_id)->update([
                    'payment'=>$request->total_pay - $request->discount,
                    'discount'=>$request->discount
                ]);
            }
            else{
                DB::table('inside_order_total')->where('order_id',$request->order_id)->update([
                    'payment'=>$request->pay,
                    'discount'=>$request->discount
                ]);
            }

            DB::commit();
        }

        catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
    }


    public function paymentOutsideList()
    {
        $orders = OutsideOrderTotal::where('payment','=',0)->where('status','2')->paginate(10);
        return view('Payment.outsidePayment.index',compact('orders'));
    }


    public function paymentOutsideCreate(Request $request)
    {

        try{

            DB::beginTransaction();
            DB::table('outside_order_total')->where('order_id',$request->order_id)->update([
                'payment'=>$request->pay,
                'discount'=>$request->discount
            ]);
            DB::commit();
        }

        catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        if ($request->print_out!=null){
            $orders = OutsideOrderTotal::where('order_id',$request->order_id)->get();
            return view('Payment.outsidePayment.print',compact('orders'))->with('success','عملیات موفقانه انجام شد.');

        }
        else{
            return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
        }


    }

    public function paymentOutsideUpdate(Request $request)
    {

        try{


            DB::beginTransaction();
            if ($request->discount!=$request->old_discount && $request->pay!=0){
                DB::table('outside_order_total')->where('order_id',$request->order_id)->update([
                    'payment'=>$request->total_pay - $request->discount,
                    'discount'=>$request->discount
                ]);
            }
            else{
                DB::table('outside_order_total')->where('order_id',$request->order_id)->update([
                    'payment'=>$request->pay,
                    'discount'=>$request->discount
                ]);
            }

            DB::commit();
        }

        catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        return redirect()->back()->with('success','عملیات موفقانه انجام شد.');

    }

    //paymentPayedOutsideList
    public function paymentPayedOutsideList(){
        $orders = OutsideOrderTotal::where('payment','>',0)->where('status','2')->paginate(10);
        return view('Payment.outsidePayment.outSidePayedList',compact('orders'));
    }


    //paymentPayedInsideList
    public function paymentPayedInsideList(){
        $orders = InsideOrderTotal::where('payment','>',0)->where('status','2')->paginate(10);
        return view('Payment.insidePayment.inSidePayedList',compact('orders'));
    }

    public function outSideCreate()
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
        return view('payment.outsidePayment.outsideOrderCreate',compact(['menu','categories','tables']));
    }


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
        $response = array(
            'status' => 'success',
            'msg' => 'موفقانه انجام شد!',
        );
        return response($response);
    }

    public function insideCreate()
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
        return view('payment.insidePayment.newCreate',compact(['menu','categories','tables']));
    }


    public function insideStore(Request $request)
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

    public function paymentGetMenu(Request $request)
    {
        $id = $request->get('id');
        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.*')
            ->where('menu.category_id', '=', $id)
            ->get();
        return view('Payment.outsidePayment.table', compact('menu'));
    }
    public function paymentInSearch()
    {
        $orders = InsideOrderTotal::where('payment','=',0)->where('status','2')->paginate(10);
        return view('payment.insidePayment.search',compact('orders'));
    }

    public function paymentOutSearch()
    {
        $orders = OutsideOrderTotal::where('payment','=',0)->where('status','2')->paginate(10);
        return view('payment.outsidePayment.search',compact('orders'));
    }


    public function paymentInGetMenu(Request $request)
    {
        $id = $request->get('id');
        $menu = DB::table('menu')
            ->join('categories', 'menu.category_id', '=', 'categories.category_id')
            ->select('menu.*')
            ->where('menu.category_id', '=', $id)
            ->get();
        return view('Payment.insidePayment.table', compact('menu'));
    }
}
