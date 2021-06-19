@extends('dashboard.layouts.app')
@section('main_content')
    <div class="chart">
        <div class="col-md-12 mt-3 mb-3" style="text-align: center"><h5>مجموع سفارشات داخلی</h5></div>
        <div class="row mt-2" style="padding: 0px 10px;text-align: center">
            <div class="card col-md-3">
                <div class="card-body">
                    مجموع سفارشات کل
                    <div class="body">
                        {{$inTotal}}
                    </div>
                </div>
            </div>
            @foreach($category as $c)
                <div class="card col-md-3">
                    <div class="card-body">
                        {{$c->name}}

                        <div class="body">
                            @php
                               echo DB::table('inside_order')
                                ->join('menu', 'menu.menu_id', '=', 'inside_order.menu_id')
                                ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                                ->where('categories.category_id',$c->category_id)
                                ->sum('order_amount');
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="col-md-12 mt-3 mb-3" style="text-align: center"><h5>مجموع سفارشات بیرونی</h5></div>
        <div class="row mt-2" style="padding: 0px 10px;text-align: center">
            <div class="card col-md-3">
                <div class="card-body">
                    مجموع کل سفارشات
                    <div class="body">
                        {{$outTotal}}
                    </div>
                </div>
            </div>
            @foreach($category as $c)
                <div class="card col-md-3">
                    <div class="card-body">
                        {{$c->name}}

                        <div class="body">
                            @php
                                echo DB::table('outside_order')
                                 ->join('menu', 'menu.menu_id', '=', 'outside_order.menu_id')
                                 ->join('categories', 'categories.category_id', '=', 'menu.category_id')
                                 ->where('categories.category_id',$c->category_id)
                                 ->sum('order_amount');
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="row mb-2" style="padding: 0px 10px">
            <div class=" card col-md-12 col-sm-12" style="height: 90%;background: #fff;
    padding: 10px 27px 47px 10px; text-align: center; ">
                <h6 style="margin-bottom: 20px"> پرداختی های کلی نظر به ماه </h6>
                <canvas id="myChart"></canvas>
            </div>
            {{--<div class="card col-md-6 col-sm-6" style="background: #fff;--}}
    {{--padding: 10px 27px; text-align: center">--}}
                {{--<h6 style="margin-bottom: 20px"> پرداختی های هر بخش نظر به فیصدی در یک سال</h6>--}}
                {{--<canvas id="myChart2"></canvas>--}}
            {{--</div>--}}
        </div><!-- /.row -->

    </div>
@endsection

@section('style')
    <style>
        #myChart {
            height: 480px !important;
            /*width: 550px !important;*/
        }

        #myChart2 {
            height: 400px !important;
            width: 500px !important;
        }

        .body {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('script')
    <script src="{{asset('assets/js/chart.min.js')}}"></script>
    <script type="text/javascript">

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    "جدی",
                    "دلو",
                    "حوت",
                    "حمل",
                    "ثور",
                    "جوزا",
                    "سرطان",
                    "اسد",
                    "سنبله",
                    "میزان",
                    "عقرب",
                    "قوس",
                ],
                datasets: [{

                    data: {!! json_encode($arr3) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        {{--var ctx2 = document.getElementById('myChart2').getContext('2d');--}}
        {{--var myChart2 = new Chart(ctx2, {--}}
            {{--type: 'doughnut',--}}
            {{--data: {--}}
                {{--labels: [--}}
                    {{--"غذا ها",--}}
                    {{--"نوشیدنیی ها",--}}
                    {{--"بستنی ها",--}}

                {{--],--}}
                {{--datasets: [{--}}

                    {{--data: [{!! json_encode($Fto) !!},{!! json_encode($DTo) !!},{!! json_encode($ICTo) !!}],--}}
                    {{--backgroundColor: [--}}
                        {{--'rgba(255, 99, 132, 0.2)',--}}
                        {{--'rgba(54, 162, 235, 0.2)',--}}
                        {{--'rgba(255, 206, 86, 0.2)',--}}
                        {{--'rgba(75, 192, 192, 0.2)',--}}
                        {{--'rgba(153, 102, 255, 0.2)',--}}
                        {{--'rgba(255, 159, 64, 0.2)'--}}
                    {{--],--}}
                    {{--borderColor: [--}}
                        {{--'rgba(255, 99, 132, 1)',--}}
                        {{--'rgba(54, 162, 235, 1)',--}}
                        {{--'rgba(255, 206, 86, 1)',--}}
                        {{--'rgba(75, 192, 192, 1)',--}}
                        {{--'rgba(153, 102, 255, 1)',--}}
                        {{--'rgba(255, 159, 64, 1)'--}}
                    {{--],--}}
                    {{--borderWidth: 1--}}
                {{--}]--}}
            {{--},--}}
            {{--options: {--}}
                {{--scales: {--}}
                    {{--y: {--}}
                        {{--beginAtZero: false--}}
                    {{--}--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}

    </script>
@endsection