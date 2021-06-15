<?php

namespace App\Http\Controllers;

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
                'discount'=>$request->discount
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
        return view('payment.outsidePayment.outsideOrderCreate',compact(['food','drink','icecream','tables']));
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
}
