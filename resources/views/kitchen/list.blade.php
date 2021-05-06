@extends('Kitchen.layouts.app')
@section('main_content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark text-center"> لیست سفارشات داخلی </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container my-4">

        <div id="accordion">

            @foreach($orders as $index => $order)

                @if($index == 0)

                    <div class="card">
                        <div class="card-header" id="head{{ $order->order_id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapse{{ $order->order_id }}" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    سفارش : {{ $order->name .' - '.'نمبر سفارش'. ' '.$order->identity }}
                                </button>
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
                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $insideOrders = \App\InsideOrder::where('total_id', '=', $order->order_id)->get();
                                    ?>
                                    @foreach($insideOrders as $index => $inside)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $inside->menu->name }}</td>
                                            <td>{{ $inside->menu->category->name }}</td>
                                            <td>{{ $inside->order_amount }}</td>
                                            <td>
                                                @if($order->status=='1')
                                                    <button id="send_order" class="btn btn-primary btn-xs"
                                                            order_id="{{$order->order_id}}">ارسال<i id="send_icon"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-xs" disabled>ارسال شده</button>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>مشخصه</th>
                                        <th>اسم سفارش</th>
                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- /card -->

                @else

                    <div class="card">
                        <div class="card-header" id="head{{ $order->order_id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapse{{ $order->order_id }}" aria-expanded="false"
                                        aria-controls="collapseOne">
                                    سفارش : {{ $order->name .' - '.'نمبر سفارش'. ' '.$order->identity }}
                                </button>
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

                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $insideOrders = \App\InsideOrder::where('total_id', '=', $order->order_id)->get();
                                    ?>
                                    @foreach($insideOrders as $index => $inside)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $inside->menu->name }}</td>
                                            <td>{{ $inside->menu->category->name }}</td>
                                            <td>{{ $inside->order_amount }}</td>
                                            <td>
                                                @if($order->status=='1')
                                                    <button id="send_order" class="btn btn-primary btn-xs"
                                                            order_id="{{$order->order_id}}">ارسال<i id="send_icon"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-xs" disabled>ارسال شده</button>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>مشخصه</th>
                                        <th>اسم سفارش</th>
                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div> <!-- /card -->

                @endif

            @endforeach

        </div> <!-- /accordion -->

        {{--<div class="pagination">--}}
            {{--{{ $orders->links() }}--}}
        {{--</div>--}}

    </div> <!-- /container -->
@endsection

@section('style')

@endsection
<style type="text/css">
    .alert {
        position: fixed;
        bottom: 0;
        z-index: 10;
        left: 20px;
    }

    .alert button {
        margin-left: 5px;
    }
</style>
@section('script')
    <script type="text/javascript">

        //refresh table after 30 seconds to see the new order
        setInterval(function(){
        $.ajax({
            url: '{{route('kitchenSearch')}}',
            type: 'GET',

            success: function (response) {

                    $('#accordion').html(response);

            }, error: function (err) {

            }
        })
        }, 30000);


        //send order from kitchen

        $('table tbody').on('click', 'button', function () {
            var order_id = $(this).attr("order_id");

            $.ajax({
                url: '{{route('sendOrders')}}',
                type: 'GET',
                dataType: 'json',
                data: {
                    'id': order_id
                },
                success: function (response) {
                    if (response) {
                        alert('ارسال شد!');
                        window.location.reload();
                    }
                    else {
                        alert('ارسال نشد!')
                    }

                }, error: function (err) {


                }
            })

        });
    </script>
@endsection