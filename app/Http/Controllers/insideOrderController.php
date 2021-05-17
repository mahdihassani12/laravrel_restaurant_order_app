<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\InsideOrder;
use App\InsideOrderTotal;
use App\Table;
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
		$orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        return view('order.insideOrder.index',compact('orders'));
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
        return view('order.insideOrder.create',compact(['food','drink','icecream','tables']));
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
                'table_order'  => 'required'
            ],[
                'menu_id.required'  => 'افزودن مینوی غذایی الزامی است.',
                'order_amount.required' => 'تعداد سفارشات الزامی است.',
                'total.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'table_order.required' => 'انتخاب میز الزامی است',
                'order_price.required' => 'هیچ مقدار پولی وارد نشده است.',
            ]);


            $total = new InsideOrderTotal();
            $data = $request -> all();

            $total -> location_id = $data['table_order'];
            $total -> total = $data['total'];
            $total -> identity =\random_int(100000, 999999);
            $total -> save();

            foreach ($request->input('menu_id') as $item => $value) {

                $order = new InsideOrder();
                $order -> total_id = $total->order_id;
                $order -> menu_id = $data['menu_id'][$item];
                $order -> order_amount = $data['order_amount'][$item];
                $order -> price = $data['order_price'][$item];
                $order -> save();

            }
            DB::commit();
        }
        
        catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('errors','error');
        }
        return redirect()->back()->with('success','عملیات موفقانه انجام شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function continueOrder()
    {
       $orders = InsideOrderTotal::orderby('order_id','desc')->paginate(10);
        return view('order.insideOrder.continue',compact('orders'));
    }

    public function orderSearch(Request $request)
    {
        $data = $request->all();
        $order = InsideOrderTotal::where('identity','like', '%'.$request->search.'%')->first();
		$insideOrders = InsideOrder::where('total_id','=',$order->order_id)->get();
		
		return view('order.insideOrder.search',compact(['order','insideOrders']));
		
        //return response()->json(
          //   [
            //   'order'       => $order,
              // 'insideOrder' => $insideOrder
             //]
        //);

    }


    public function loadInsideData($id)
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

        $orders = DB::table('inside_order_total as in')
            ->join('inside_order as ot','ot.total_id','=','in.order_id')
            ->join('menu', 'menu.menu_id', '=', 'ot.menu_id')
            ->join('categories', 'categories.category_id', '=', 'menu.category_id')
            ->select( 'menu.name as menu_name',  'ot.order_amount', 'in.order_id', 'ot.total_id','categories.name','in.status','ot.price','ot.menu_id')
            ->where('in.order_id','=',$id)
            ->get();
        $t_orders = InsideOrderTotal::find($id);

        return view('order.insideOrder.edit',compact(['food','drink','icecream','tables','t_orders','orders']));

    }

    public function updateInsideOrder(Request $request,$id){

        try{

            DB::beginTransaction();
            $request->validate([
                'menu_id_field' => 'required',
                'order_amount_field' => 'required',
                'order_price_field'  => 'required',
                'total_payment'     => 'required',
                'table_name'  => 'required'
            ],[
                'menu_id_field.required'  => 'افزودن مینوی غذایی الزامی است.',
                'order_amount_field.required' => 'تعداد سفارشات الزامی است.',
                'order_price_field.required' => 'مقدار کلی پول باید بیشتر از صفر باشد.',
                'table_name.required' => 'انتخاب میز الزامی است',
                'total_payment.required' => 'هیچ مقدار پولی وارد نشده است.',
            ]);


            $total =InsideOrderTotal::find($id);
            $data = $request -> all();

            $total -> location_id = $data['table_name'];
            $total -> total = $data['total_payment'];
            $total -> identity =$data['identity'];
            $total -> save();
            DB::table('inside_order')->where('total_id',$id)->delete();
            foreach ($request->input('menu_id_field') as $item => $value) {

                $order = new InsideOrder();
                $order -> total_id = $total->order_id;
                $order -> menu_id = $data['menu_id_field'][$item];
                $order -> order_amount = $data['order_amount_field'][$item];
                $order -> price = $data['order_price_field'][$item];
                $order -> save();

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
