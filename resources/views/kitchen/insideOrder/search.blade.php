@foreach($orders as $index => $order)

    @if($index == 0)

        <div class="card">
            <form id="order" method="post" action="{{ route('sendOrders') }}">
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


                            <button type="submit" class="btn btn-success btn-xs"
                                    order_id="{{$order->order_id}}"
                                    style="float: left; margin-left: 30px !important;" id="pay_print">ارسال و چاپ<i id="send_icon"></i>
                            </button>
                        @else
                            <button class="btn btn-success btn-xs" disabled style="float:left;">ارسال شده</button>

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
            <form id="order" method="post" action="{{ route('sendOrders') }}">
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


                            <button type="submit" class="btn btn-success btn-xs"
                                    order_id="{{$order->order_id}}"
                                    style="float: left; margin-left: 30px !important;" id="pay_print">ارسال و چاپ<i id="send_icon"></i>
                            </button>
                        @else
                            <button class="btn btn-success btn-xs" disabled style="float:left;">ارسال شده</button>

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