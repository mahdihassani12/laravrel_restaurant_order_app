@extends('Kitchen.layouts.app')
@section('main_content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark text-center"> لیست سفارشات بیرونی </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container my-4">

        <div id="accordion">

            @foreach($orders as $index => $order)

                @if($index == 0)

                    <div class="card">
                        <form id="order" method="post" action="{{ route('sendOutsideOrders') }}">
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                            <input type="hidden" id="print_in" name="print_in" class="print_in">
                            <input type="hidden" step="any" id="pay{{$order->order_id}}" name="pay"
                                   class="form-control">

                            <input type="hidden" id="order_id" name="order_id" class="form-control"
                                   value="{{$order->order_id}}">
                            <div class="card-header" id="head{{ $order->order_id }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" id="collapse"
                                            data-target="#collapse{{ $order->order_id }}" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        سفارش : {{ $order->name .' - '.'نمبر سفارش'. ' '.$order->identity }}
                                    </button>
                                    @if($order->status=='1')


                                        <button  type="submit" class="btn btn-success btn-xs"
                                                order_id="{{$order->order_id}}"
                                                style="float: left; margin-left: 30px !important;" id="pay_print">ارسال و چاپ<i id="send_icon"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-xs" disabled style="float:left;">ارسال شده
                                        </button>

                                    @endif

                                </h5>
                            </div>

                            <div id="collapse{{ $order->order_id }}" class="collapse show"
                                 aria-labelledby="head{{ $order->order_id }}" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>مشخصه</th>
                                            <th>اسم سفارش</th>

                                            <th>نوعیت سفارش</th>
                                            <th>تعداد سفارش</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $insideOrders = \App\OutsideModel::where('total_id', '=', $order->order_id)->get();
                                        ?>
                                        @foreach($insideOrders as $index => $inside)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $inside->menu->name }}</td>
                                                <td>{{ $inside->menu->category->name }}</td>
                                                <td>{{ $inside->order_amount }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>مشخصه</th>
                                            <th>اسم سفارش</th>

                                            <th>نوعیت سفارش</th>
                                            <th>تعداد سفارش</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /card -->

                @else

                    <div class="card">
                        <form id="order" method="post" action="{{ route('sendOutsideOrders') }}">
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                            <input type="hidden" id="print_in" name="print_in" class="print_in">
                            <input type="hidden" step="any" id="pay{{$order->order_id}}" name="pay"
                                   class="form-control">

                            <input type="hidden" id="order_id" name="order_id" class="form-control"
                                   value="{{$order->order_id}}">
                            <div class="card-header" id="head{{ $order->order_id }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" id="collapse"
                                            data-target="#collapse{{ $order->order_id }}" aria-expanded="false"
                                            aria-controls="collapseOne">
                                        سفارش : {{ $order->name .' - '.'نمبر سفارش'. ' '.$order->identity }}
                                    </button>
                                    @if($order->status=='1')


                                        <button  type="submit" class="btn btn-success btn-xs"
                                                order_id="{{$order->order_id}}"
                                                style="float: left; margin-left: 30px !important;" id="pay_print">ارسال و چاپ<i id="send_icon"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-xs" disabled style="float:left;">ارسال شده
                                        </button>

                                    @endif
                                </h5>
                            </div>

                            <div id="collapse{{ $order->order_id }}" class="collapse"
                                 aria-labelledby="head{{ $order->order_id }}" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>مشخصه</th>
                                            <th>اسم سفارش</th>
                                            <th>نوعیت سفارش</th>
                                            <th>تعداد سفارش</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $insideOrders = \App\OutsideModel::where('total_id', '=', $order->order_id)->get();
                                        ?>
                                        @foreach($insideOrders as $index => $inside)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $inside->menu->name }}</td>
                                                <td>{{ $inside->menu->category->name }}</td>
                                                <td>{{ $inside->order_amount }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>مشخصه</th>
                                            <th>اسم سفارش</th>

                                            <th>نوعیت سفارش</th>
                                            <th>تعداد سفارش</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /card -->

                @endif

            @endforeach

        </div> <!-- /accordion -->

        {{--<div class="pagination">--}}
        {{--{{ $orders->links() }}--}}
        {{--</div>--}}

    </div> <!-- /container -->
    <div id="printBo" style="">

    </div>
@endsection

@section('style')
    <style type="text/css">

        @media print {
            #accordion {
                visibility: hidden;
                margin-bottom: -440px !important;
            }
            .main-header{
                visibility: hidden;
            }
            /*#printBo{*/
                /*position: absolute !important;*/
                /*!*margin-top: -50px !important;*!*/
            /*}*/
            /*@page {*/
                /*margin: 0;*/

            /*}*/

        }
    </style>

@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('button#pay_print').click(function () {

                $('.print_in').val(1)
            });

            $('#accordion').on('click','button#collapse',function(e){
                e.preventDefault()
            })
        })
        let app = @json($orders);
        console.log(app.length)
        //refresh table after 30 seconds to see the new order
        setInterval(function () {
            $.ajax({
                url: '{{route('kitchenOutsideSearch')}}',
                type: 'GET',

                success: function (response) {

                    $('#accordion').html(response);

                }, error: function (err) {

                }
            })
        }, 10000);




        var APP_URL = {!! json_encode(url('/')) !!}
        setInterval(function () {
            $.ajax({
                url: '{{route('getNotification')}}',
                type: 'GET',

                success: function (response) {
                    let bef = $('.badge').text();

                    console.log(parseInt(bef));
                    $('.badge').empty();
                    $('.badge').text(response);

                    // if (parseInt(bef) != parseInt(response)) {
                    //     // var audio = new Audio(APP_URL + "/assets/sound/beep-01a.mp3");
                    //     // audio.play();
                    //     // window.location= APP_URL +
                    // }

                    $.ajax({
                        type: "GET",
                        url: '{{route('sendOutOrdersForPrint')}}',
                        success: function (data) {
                            $('#printBo').html(data)
                        }
                    });

                }, error: function (err) {

                }
            })
        }, 10000);


    </script>
@endsection