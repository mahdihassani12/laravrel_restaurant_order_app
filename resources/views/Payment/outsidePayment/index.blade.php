@extends('Payment.layouts.app')
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
                        <div class="card-header" id="head{{ $order->order_id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapse{{ $order->order_id }}" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    شماره سفارش : {{ $order->identity }} - مجموع فیس: {{$order->total_payment}} - باقی
                                    : {{$order->total_payment - ($order->payment+$order->discount)}}
                                    - نام مشتری:{{$order->name}}
                                </button>
                                @if($order->total_payment==$order->payment || $order->payment > 0)
                                    <a id="send_order"
                                       class="btn  btn-xs"
                                       style="float: left" data-toggle="modal"
                                       data-target="#edit{{ $order->order_id }}"><i class="fa fa-edit"
                                                                                    id="send_icon"></i>
                                    </a>
                                @else
                                    <a id="send_order"
                                       class="btn btn-xs btn-outline-primary"
                                       style="float: left;margin-right: 2%" data-toggle="modal"
                                       data-target="#exampleModalLong{{ $order->order_id }}">پرداخت با تخفیف
                                    </a>
                                    <a id="send_order_without_discount"
                                       class="btn btn-xs btn-outline-success"
                                       style="float: left" pay="{{$order->total_payment}}"
                                       order_id="{{$order->order_id}}">پرداخت
                                    </a>
                                    <a id="delete_order"
                                       style="float: left; margin-top: 7px; margin-left: 20px !important;cursor:pointer;"
                                       order_id="{{$order->order_id}}"><i class="fa fa-trash"
                                        id="delete_icon" ></i>
                                    </a>
                                @endif
                                {{--<input type="number" name="discount" id="discount" class="col-md-2 form-control" placeholder="تخفیف" style="display: inline">--}}
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
                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
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
                                        data-target="#collapse{{ $order->order_id }}" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    شماره سفارش : {{ $order->identity }} - مجموع فیس: {{$order->total_payment}} - باقی
                                    : {{$order->total_payment - ($order->payment+$order->discount)}}
                                    - نام مشتری: {{$order->name}}
                                </button>
                                @if($order->total_payment==$order->payment || $order->payment > 0)
                                    <a id="send_order"
                                       class="btn  btn-xs"
                                       style="float: left" data-toggle="modal"
                                       data-target="#edit{{ $order->order_id }}"><i class="fa fa-edit"
                                                                                    id="send_icon"></i>
                                    </a>
                                @else
                                    <a id="send_order"
                                       class="btn btn-xs btn-outline-primary"
                                       style="float: left;margin-right: 2%" data-toggle="modal"
                                       data-target="#exampleModalLong{{ $order->order_id }}">پرداخت با تخفیف
                                    </a>
                                    <a id="send_order_without_discount"
                                       class="btn btn-xs btn-outline-success"
                                       style="float: left" pay="{{$order->total_payment}}"
                                       order_id="{{$order->order_id}}">پرداخت
                                    </a>
                                    <a id="delete_order"
                                       style="float: left; margin-top: 7px; margin-left: 20px !important; cursor:pointer;"
                                       order_id="{{$order->order_id}}"><i class="fa fa-trash"
                                        id="delete_icon" ></i>
                                    </a>
                                @endif
                                {{--<input type="number" name="discount" id="discount" class="col-md-2 form-control" placeholder="تخفیف" style="display: inline">--}}

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
                                        <th>تعداد سفارش</th>
                                        <th>نوعیت سفارش</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div> <!-- /card -->

                @endif
            <!-- Modal payment and discount -->
                <div class="modal fade payment_modal" id="exampleModalLong{{ $order->order_id }}" tabindex="-1"
                     role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="margin-top: 70px">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" id="printThis">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"> بل پرداختی
                                    آقا/خانم {{$order->name}}</h5>

                            </div>
                            <form class="form_payment">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th>#</th>
                                    <th>اسم سفارش</th>
                                    <th>نوعیت</th>
                                    <th>تعداد</th>
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
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th> مقدار کل</th>
                                        <th> تخفیف</th>
                                        <th> مقدار قابل پرداخت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span id="total_pay{{$order->order_id}}">{{$order->total_payment}}</span>
                                        </td>
                                        <td><input type="number" name="discount" class="discount form-control"
                                                   data-id="{{$order->order_id}}" value="0"></td>
                                        <td><span id="pay_amount{{$order->order_id}}">{{$order->total_payment}}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                                <div class="modal-body">
                                    <input type="hidden" step="any" id="pay{{$order->order_id}}" name="pay"
                                           class="form-control" value="{{$order->total_payment}}">

                                    <input type="hidden" id="order_id" name="order_id" class="form-control"
                                           value="{{$order->order_id}}">
                                </div>
                                <input type="hidden" id="print_out" name="print_out">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary pay_noPrint" id="pay_noPrint">پرداخت
                                    </button>
                                    {{--<button type="submit"  class="btn btn-success" onclick="print()" id="pay_print" style="margin-right: 180px !important;">پرداخت و چاپ</button>--}}
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            style="margin-right: 62% !important;">بستن
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Modal edition -->
                <div class="modal fade " id="edit{{ $order->order_id }}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="margin-top: 70px;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">ویرایش بل پرداختی
                                    آقا/خانم {{$order->name}}</h5>

                            </div>
                            <form method="post" action="{{ route('paymentOutsideUpdate') }}">

                                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                                <div class="modal-body">
                                    <label>مقدار پرداخت</label>
                                    <input type="number" step="any" id="pay" name="pay" class="form-control"
                                           value="{{$order->payment}}">
                                    <input type="hidden" step="any" id="total_pay" name="total_pay" class="form-control"
                                           value="{{$order->total_payment}}">
                                    <label for="">مقدار تخفیف</label>
                                    <input type="number" name="discount" id="discount" class="form-control"
                                           value="{{$order->discount}}">
                                    <input type="hidden" name="old_discount" id="old_discount" class="form-control"
                                           value="{{$order->discount}}">
                                    <input type="hidden" id="order_id" name="order_id" class="form-control"
                                           value="{{$order->order_id}}">

                                </div>
                                <div class="modal-footer" style="text-align: right !important;">
                                    <button type="submit" class="btn btn-primary" id="pay_print2">پرداخت</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            style="margin-right: 20px !important;">بستن
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div> <!-- /accordion -->

        <div class="pagination">
            {{ $orders->links() }}
        </div>

    </div> <!-- /container -->

@endsection

@section('style')
    <style>
        .alert {
            position: fixed;
            bottom: 0;
            z-index: 10;
            left: 20px;
        }

        .alert button {
            margin-left: 5px;
        }

        .fa-edit {
            color: blue;
        }

        .fa-trash {
            color: red;
        }

        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .printSection, .printSection * {
                visibility: visible;
            }

            .printSection {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('change', ".discount", function (el) {
            var id = $(this).data('id');
            console.log(id)
            var t = $('#total_pay' + id).text();
            var d = $(el.target).val();
            var p = parseInt(t) - parseInt(d);
            $('#pay_amount' + id).text(p)
            $('#pay' + id).val(p)
        });
        $(document).ready(function () {
            setInterval(function () {
                $.ajax({
                    url: '{{route('paymentOutSearch')}}',
                    type: 'GET',

                    success: function (response) {
                        $('#accordion').html(response);

                    }, error: function (err) {

                    }
                })
            }, 20000);
            //send data to controller with discount
            $(document).on('submit', "form.form_payment", function (e) {
                $('.pay_noPrint').prop('disabled', true);
                e.preventDefault()

                $.ajax({
                    type: "POST",
                    url: "{{route('paymentOutsideCreate')}}",
                    data: $(this).serialize(),
                    success: function (msg) {
                        alert(msg.msg)

                        $('.pay_noPrint').prop('disabled', false);
                        $.ajax({
                            url: '{{route('paymentOutSearch')}}',
                            type: 'GET',

                            success: function (response) {
                                $('#accordion').html(response);

                            }
                        })
                    }
                });
                // return true;
            });
            //close modal after sending data to controller
            $(function () {
                $('.pay_noPrint').click(function () {
                    $('.modal').modal('hide');
                });
            });
            //send data to controller without discount
            $(document).on('click', '#send_order_without_discount', function () {
                $.ajax({
                    type: "POST",
                    url: "{{route('paymentOutsideCreate')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'pay': $(this).attr('pay'),
                        'order_id': $(this).attr('order_id'),
                        'discount': 0,
                        'print_in': null
                    },
                    success: function (msg) {
                        alert(msg.msg)

                        $('.pay_noPrint').prop('disabled', false);
                        $.ajax({
                            url: '{{route('paymentOutSearch')}}',
                            type: 'GET',

                            success: function (response) {

                                $('#accordion').html(response);

                            }
                        })
                    }
                });
            })

            //delete order by ajax
            $(document).on('click', 'a#delete_order', function () {
                let order_id= $(this).attr('order_id');
                $.ajax({
                    type: "get",
                    url: "{{route('deleteOutsidePayment')}}",
                    data:{
                      'id':order_id
                    },
                    success: function (msg) {
                        alert(msg.msg)

                        $('.pay_noPrint').prop('disabled', false);
                        $.ajax({
                            url: '{{route('paymentOutSearch')}}',
                            type: 'GET',

                            success: function (response) {

                                $('#accordion').html(response);

                            }
                        })
                    }
                });
            })
        });

        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementsByClassName("print");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            for (var i = 0; i < $printSection.length; i++) {
                $printSection[i].style.size = '100px';
            }
            $printSection.appendChild(domClone);
            window.print();
        }

        function print() {
            document.getElementById('print_out').value = 1;
        }
    </script>
@endsection