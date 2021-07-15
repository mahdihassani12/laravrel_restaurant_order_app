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
                           class="btn btn-xs"
                           style="float: left" data-toggle="modal"
                           data-target="#exampleModalLong{{ $order->order_id }}"><i class="fa fa-paypal"
                                                                                    id="send_icon"></i>
                        </a>
                        <a id="delete_order"

                           style="float: left; margin-top: 7px; margin-left: 20px !important;"
                           href="{{route('deleteOutsidePayment',$order->order_id)}}"><i class="fa fa-trash"
                                                                                        id="delete_icon"></i>
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
                           class="btn btn-xs"
                           style="float: left" data-toggle="modal"
                           data-target="#exampleModalLong{{ $order->order_id }}"><i class="fa fa-paypal"
                                                                                    id="send_icon"></i>
                        </a>
                        <a id="delete_order"

                           style="float: left; margin-top: 7px; margin-left: 20px !important;"
                           href="{{route('deleteOutsidePayment',$order->order_id)}}"><i class="fa fa-trash"
                                                                                        id="delete_icon"></i>
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
    <div class="modal fade print" id="exampleModalLong{{ $order->order_id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="margin-top: 70px">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="printThis">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> بل پرداختی
                        آقا/خانم {{$order->name}}</h5>

                </div>
                <form id="order" method="post" action="{{ route('paymentOutsideCreate') }}">
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
                            <td><span id="total_pay{{$order->order_id}}">{{$order->total_payment}}</span></td>
                            <td><input type="number" name="discount"  class="discount form-control"  data-id="{{$order->order_id}}" value="0"></td>
                            <td><span id="pay_amount{{$order->order_id}}">{{$order->total_payment}}</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                    <div class="modal-body">
                        <input type="hidden" step="any" id="pay{{$order->order_id}}" name="pay" class="form-control" value="{{$order->total_payment}}">

                        <input type="hidden" id="order_id" name="order_id" class="form-control"
                               value="{{$order->order_id}}">
                    </div>
                    <input type="hidden" id="print_out" name="print_out">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"  >پرداخت</button>
                        <button type="submit"  class="btn btn-success" onclick="print()" id="pay_print" style="margin-right: 180px !important;">پرداخت و چاپ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                style="margin-right: 20px !important;">بستن
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
                        <input type="number" step="any" id="pay" name="pay" class="form-control" value="{{$order->payment}}">
                        <input type="hidden" step="any" id="total_pay" name="total_pay" class="form-control" value="{{$order->total_payment}}">
                        <label for="">مقدار تخفیف</label>
                        <input type="number" name="discount" id="discount" class="form-control" value="{{$order->discount}}">
                        <input type="hidden" name="old_discount" id="old_discount" class="form-control" value="{{$order->discount}}">
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