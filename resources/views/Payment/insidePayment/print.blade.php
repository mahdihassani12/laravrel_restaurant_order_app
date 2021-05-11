
@extends('Payment.layouts.app')
@section('main_content')

    @foreach($orders as $index => $order)
        <div class="container" style="width: 400px !important;">
            <div class="header" style="margin-top: 30px !important;">
                <h5 class="modal-title" id="exampleModalLongTitle"> بل پرداختی
                    </h5>

            </div>

            <table class="table table-bordered table-striped">
                <thead>
                <th>#</th>
                <th>اسم سفارش</th>
                <th>نوعیت</th>
                <th>تعداد</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table class="table table-bordered" style="margin-top: -16px !important">
                <thead>
                <tr>
                    <th> مقدار کل</th>
                    <th> تخفیف</th>
                    <th> مقدار قابل پرداخت</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$order->total}}</td>
                    <td>{{$order->discount}}</td>
                    <td>{{$order->payment}}</td>
                </tr>
                </tbody>
            </table>
            <div class="backward">
                <a href="{{route('paymentInsideList')}}" class="btn btn-primary">برگشت به صفحه قبل</a>
            </div>
        </div>

    @endforeach


@endsection

@section('style')
    <style>
        @media print {
            .container{
                width: 30% !important;
            }
            @page  {
                margin: 0;

            }
            footer,.backward{
                visibility: hidden !important;
            }
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        window.print()
    </script>
@endsection