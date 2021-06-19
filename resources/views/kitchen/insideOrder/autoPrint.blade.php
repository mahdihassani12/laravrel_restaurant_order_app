@extends('Payment.layouts.app')
@section('main_content')

    @foreach($orders as $index => $order)
        <div class="container">
            <div class="header" style="margin-top: 30px !important; width: 400px; text-align: center">
                <h4 class="modal-title" id="exampleModalLongTitle"> بستنی و فست فود گیلاتو
                </h4>

            </div>
            <div class="header" style="width: 400px; text-align: center;margin-top: 8px">
                <p>{{$order->table->name.' '.'نمبر سفارش: '.$order->identity}}</p>


            </div>
            <table class="table table-bordered table-striped" style="width: 400px ">
                <thead>
                <th>#</th>
                <th>اسم سفارش</th>
                <th>نوعیت</th>
                <th>تعداد</th>
                <th>قیمت</th>
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
                        <td>{{ $inside->price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table class="table table-bordered" style="margin-top: -16px !important;width: 400px">
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
                    <td>{{$order->total-$order->discount}}</td>
                </tr>
                </tbody>
            </table>
            <h6 style="margin-right: 75px">تاریخ صدور: {{$date}}</h6>
            <h6 class="footer" style="margin-right: 35px">شماره های تماس: <span>0792469946 - 0789190444</span></h6>
            <h4 style="margin-right: 60px">با خدمات پیک موتوری رایگان</h4>
            <hr style="padding: 0; margin: 0">
            <span style="font-size: 18px; text-align: center; margin-right: 10px !important;">سازنده: شرکت تکنالوژی طوطیا www.tutiatech.com</span>
            <div class="backward">
                <a href="{{route('getOrders')}}" class="btn btn-primary" style="margin-right: 82px">برگشت به صفحه
                    قبل</a>
            </div>

        </div>

    @endforeach

@endsection

@section('style')
    <style>
        @media print {
            .container {
                width: 30% !important;
            }

            @page {
                margin: 0;

            }

            footer, .backward {
                visibility: hidden !important;
            }

            .container {
                margin-right: -20px !important;
            }
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">

        window.print()
        setInterval(function () {
            var APP_URL = {!! json_encode(url('/')) !!}
                window.location = APP_URL + "/getOrders"
        }, 2000);


    </script>
@endsection/