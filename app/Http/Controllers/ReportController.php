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

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->groupBy('menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                   $sum = DB::table('inside_order as io')
                       ->whereBetween('io.created_at',[$start_month_date,$jdate])
                       ->sum(DB::raw('price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'type'=>$request->reason
                ]);

            } else {
               $start_date=$request->start_date;
               $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);

                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->groupBy('menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                return response([
                    'data'=>$data,
                    'sum'=>$sum,
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

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->where('menu.category_id',$request->menu)
                    ->sum(DB::raw('io.price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'type'=>$request->reason
                ]);
            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);


                $data = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('inside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->where('menu.category_id',$request->menu)
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->sum(DB::raw('io.price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
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

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->groupBy('menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->sum(DB::raw('price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'type'=>$request->reason
                ]);

            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);

                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->groupBy('menu.menu_id')
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                return response([
                    'data'=>$data,
                    'sum'=>$sum,
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

                $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->whereBetween('io.created_at',[$start_month_date,$jdate])
                    ->where('menu.category_id',$request->menu)
                    ->sum(DB::raw('io.price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
                    'type'=>$request->reason
                ]);
            } else {
                $start_date=$request->start_date;
                $end_date=$request->end_date;

                $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);


                $data = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->select( 'menu.name as menu_name',  'order_amount as or_am',
                        'io.price','io.total_id','io.created_at')
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->where('menu.category_id',$request->menu)
                    ->orderByDesc('or_am')
                    ->get();
                $sum = DB::table('outside_order as io')
                    ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                    ->where('menu.category_id',$request->menu)
                    ->whereBetween('io.created_at',[$start_date,$end_date])
                    ->sum(DB::raw('io.price*order_amount'));

                return response([
                    'data'=>$data,
                    'sum'=>$sum,
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

        if ($request->reason == 1) {
            if ($request->menu=='all'){
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

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->groupBy('menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->sum(DB::raw('price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);

                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->groupBy('menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->sum(DB::raw('price*order_amount'));
//                   dd($data);
                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
            }
            else{

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

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);

                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);

                    $data = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  DB::raw("SUM(order_amount) as or_am"), 'io.order_id',DB::raw("SUM(io.price*io.order_amount) as total_price"),
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->where('menu.category_id',$request->menu)
                        ->groupBy('menu.menu_id')
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('inside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));
//                   dd($data);
                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
            }

        }
        else {
            if ($request->menu=='all'){
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

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  'order_amount as or_am',
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->sum(DB::raw('io.price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  'order_amount as or_am',
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->sum(DB::raw('io.price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
            }
            else{
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

                    $start_month_date = CalendarUtils::createDatetimeFromFormat('Y-m-d', $start_month_date);
                    $jdate = CalendarUtils::createDatetimeFromFormat('Y-m-d', $jdate);


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  'order_amount as or_am',
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->whereBetween('io.created_at',[$start_month_date,$jdate])
                        ->where('menu.category_id',$request->menu)
                        ->sum(DB::raw('io.price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
                else {
                    $start_date=$request->start_date;
                    $end_date=$request->end_date;

                    $start_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $start_date);
                    $end_date = CalendarUtils::createDatetimeFromFormat('Y/m/d', $end_date);


                    $data = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->select( 'menu.name as menu_name',  'order_amount as or_am',
                            'io.price','io.total_id','io.created_at')
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->where('menu.category_id',$request->menu)
                        ->orderByDesc('or_am')
                        ->get();
                    $sum = DB::table('outside_order as io')
                        ->join('menu', 'menu.menu_id', '=', 'io.menu_id')
                        ->where('menu.category_id',$request->menu)
                        ->whereBetween('io.created_at',[$start_date,$end_date])
                        ->sum(DB::raw('io.price*order_amount'));

                    return response([
                        'data'=>$data,
                        'sum'=>$sum,
                        'type'=>$request->reason
                    ]);
                }
            }

        }
    }
}
