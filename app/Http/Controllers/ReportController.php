<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{
    public function reportInside()
    {
        $categories = DB::table('categories')->select('*')->get();
        return view('Report.report',compact('categories'));
    }


    public function getInsideReport(Request $request)
    {
        //check if report type be  بر اساس بیشترین فروش

        if ($request->reason == 1) {
            if ($request->type == 'month') {
                $jmonth = $request->get('month_r');
                $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                $start_month_date = '';
                if ($jmonth < 10) {
                    $start_month_date = $jyear . '-0' . $jmonth . '-01';
                } else {
                    $start_month_date = $jyear . '-' . $jmonth . '-01';
                }


                $jdate = '';
                if ($jmonth < 10 && $jday > 9) {
                    $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                } elseif ($jday < 10 && $jmonth > 9) {
                    $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                } elseif ($jmonth < 10 && $jday < 10) {
                    $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                }

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',
                        DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->groupBy('io.created_at','menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();


                   $sum = DB::table('inside_order as io')
                       ->whereDate('io.created_at','>=',$start_month_date)
                       ->whereDate('io.created_at','<=',$jdate)
                       ->sum(DB::raw('price*order_amount'));

                $discount= DB::table('inside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);

            } else {
               $start_date=$request->start_date;
               $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                        'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->groupBy('io.created_at','menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                $discount= DB::table('inside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);

            }
        } else {
            if ($request->type == 'month') {
                $jmonth = $request->get('month_r');
                $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                $start_month_date = '';
                if ($jmonth < 10) {
                    $start_month_date = $jyear . '-0' . $jmonth . '-01';
                } else {
                    $start_month_date = $jyear . '-' . $jmonth . '-01';
                }


                $jdate = '';
                if ($jmonth < 10 && $jday > 9) {
                    $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                } elseif ($jday < 10 && $jmonth > 9) {
                    $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                } elseif ($jmonth < 10 && $jday < 10) {
                    $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                }

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->where('menu.category_id',$request->menu)
                    ->sum(DB::raw('io.price*order_amount'));

                $discount= DB::table('inside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);
            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->where('menu.category_id',$request->menu)
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum(DB::raw('io.price*order_amount'));

                $discount= DB::table('inside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);
            }
        }
    }
    //out side report
    public function reportOutside(){
        $categories = DB::table('categories')->select('*')->get();
        return view('Report.outsideReport',compact('categories'));
    }

    public function getOutsideReport(Request $request)
    {
        //check if report type be  بر اساس بیشترین فروش

        if ($request->reason == 1) {
            if ($request->type == 'month') {
                $jmonth = $request->get('month_r');
                $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                $start_month_date = '';
                if ($jmonth < 10) {
                    $start_month_date = $jyear . '-0' . $jmonth . '-01';
                } else {
                    $start_month_date = $jyear . '-' . $jmonth . '-01';
                }


                $jdate = '';
                if ($jmonth < 10 && $jday > 9) {
                    $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                } elseif ($jday < 10 && $jmonth > 9) {
                    $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                } elseif ($jmonth < 10 && $jday < 10) {
                    $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                }

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',
                        DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->groupBy('io.created_at','menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum(DB::raw('price*order_amount'));

                $discount= DB::table('outside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);


            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->groupBy('io.created_at','menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                $discount= DB::table('outside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);
            }
        }
        else {
            if ($request->type == 'month') {
                $jmonth = $request->get('month_r');
                $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                $start_month_date = '';
                if ($jmonth < 10) {
                    $start_month_date = $jyear . '-0' . $jmonth . '-01';
                } else {
                    $start_month_date = $jyear . '-' . $jmonth . '-01';
                }


                $jdate = '';
                if ($jmonth < 10 && $jday > 9) {
                    $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                } elseif ($jday < 10 && $jmonth > 9) {
                    $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                } elseif ($jmonth < 10 && $jday < 10) {
                    $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                }

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum(DB::raw('io.price*order_amount'));

                $discount= DB::table('outside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_month_date)
                    ->whereDate('io.created_at','<=',$jdate)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);
            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->where('menu.category_id',$request->menu)
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum(DB::raw('io.price*order_amount'));

                $discount= DB::table('outside_order_total as io')
                    ->whereDate('io.created_at','>=',$start_date)
                    ->whereDate('io.created_at','<=',$end_date)
                    ->sum('discount');

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'discount'=>$discount,
                    'type'=>$request->reason
                ]);
            }
        }
    }
    
    
    //get all report
    public function reportAll()
    {
        $categories = DB::table('categories')->select('*')->get();
        return view('Report.reportAll',compact('categories'));
    }


    public function getReportAll(Request $request)
    {

        if($request->reason === 'all'){
            if ($request->menu=='all'){
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','=',$date)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();

                    $sum = DB::table('inside_order as io')
                        ->whereDate('io.created_at','=',$date)
                        ->sum(DB::raw('price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->whereDate('io.created_at','=',$date)
                        ->sum('discount');
                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','=',$date)
                        ->sum('discount');
                    return response([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);

                }
                elseif ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();

                    $sum = DB::table('inside_order as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum(DB::raw('price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');
                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');
                    return response([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);

                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                    $discount= DB::table('inside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    $data = ([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);
                  return response($data);

                }
            }
            else{
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$date)
                        ->sum('discount');

                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum('discount');
                    return response([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);


                }
                elseif ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');

                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');
                    return response([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);



                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));
//                   dd($data);
                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    //outside orders
                    $data_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum_out = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount_out= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');
                    return response([
                        'data'=>$data,
                        'data_out'=>$data_out,
                        'sum'=>$sum,
                        'sum_out'=>$sum_out,
                        'discount'=>$discount,
                        'discount_out'=>$discount_out,
                        'type'=>$request->reason
                    ]);

                }
            }
        }
        elseif ($request->reason == 1) {
            if ($request->menu=='all'){
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');
                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','=',$date)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->whereDate('io.created_at','>=',$date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                if ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();

                    $sum = DB::table('inside_order as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum(DB::raw('price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                    $discount= DB::table('inside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
            }
            else{
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');
                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->whereDate('io.created_at','>=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                if ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('io.created_at','menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));
//                   dd($data);
                    $discount= DB::table('inside_order_total as io')
                        ->join('inside_order','inside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);
                }
            }

        }
        else {
            if ($request->menu=='all'){
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');

                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','=',$date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                elseif ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);
                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);
                }
            }
            else{
                if($request->type == 'daily'){
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jmonth = Jalalian::fromCarbon(Carbon::now())->getMonth();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $date = '';
                    if (intval($jmonth) < 10 && intval($jday) > 9) {
                        $date = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif (intval($jday) < 10 && intval($jmonth) > 9) {
                        $date = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif (intval($jmonth) < 10 && intval($jday) < 10) {
                        $date = $jyear . '-0' . $jmonth . '-0' . $jday;
                    } else {

                        $date = $jyear . '-' . $jmonth . '-' . $jday;

                    }
                    $date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $date)->format('Y-m-d');

                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->join('outside_order','outside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'outside_order.menu_id')
                        ->whereDate('io.created_at','=',$date)
                        ->where('menu.category_id',$request->menu)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);

                }
                elseif ($request->type == 'month') {
                    $jmonth = $request->get('month_r');
                    $jyear = Jalalian::fromCarbon(Carbon::now())->getYear();
                    $jday = Jalalian::fromCarbon(Carbon::now())->getDay();

                    $start_month_date = '';
                    if ($jmonth < 10) {
                        $start_month_date = $jyear . '-0' . $jmonth . '-01';
                    } else {
                        $start_month_date = $jyear . '-' . $jmonth . '-01';
                    }


                    $jdate = '';
                    if ($jmonth < 10 && $jday > 9) {
                        $jdate = $jyear . '-0' . $jmonth . '-' . $jday;
                    } elseif ($jday < 10 && $jmonth > 9) {
                        $jdate = $jyear . '-' . $jmonth . '-0' . $jday;

                    } elseif ($jmonth < 10 && $jday < 10) {
                        $jdate = $jyear . '-0' . $jmonth . '-0' . $jday;
                    }

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date)->format('Y-m-d');
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate)->format('Y-m-d');


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->join('outside_order','outside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'outside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_month_date)
                        ->whereDate('io.created_at','<=',$jdate)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);
                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date)->format('Y-m-d');
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date)->format('Y-m-d');


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"),
                            'io.price','io.total_id','io.created_at')
                        ->groupBy('io.created_at','menu.menu_id')
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum(DB::raw('io.price*order_amount'));

                    $discount= DB::table('outside_order_total as io')
                        ->join('outside_order','outside_order.total_id','=','io.order_id')
                        ->join('menu', 'menu.menu_id', '=', 'outside_order.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereDate('io.created_at','>=',$start_date)
                        ->whereDate('io.created_at','<=',$end_date)
                        ->sum('discount');

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'discount'=>$discount,
                        'type'=>$request->reason
                    ]);
                }
            }

        }
    }
}
