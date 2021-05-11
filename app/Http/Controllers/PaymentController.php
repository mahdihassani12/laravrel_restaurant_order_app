<?php

namespace App\Http\Controllers;

use App\InsideOrderTotal;
use App\OutsideOrderTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    public function paymentInsideList()
    {
        $orders = InsideOrderTotal::orderby('order_id','desc')->where('status','2')->paginate(10);
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
        $orders = OutsideOrderTotal::orderby('order_id','desc')->where('status','2')->paginate(10);
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


}
