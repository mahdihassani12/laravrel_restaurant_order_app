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
                    @if($order->status=='1')
                        <button id="send_order" class="btn btn-primary btn-xs"
                                order_id="{{$order->order_id}}" onclick="sendOrder(this)" style="float: left">ارسال<i id="send_icon"></i>
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
                            <th>تعداد سفارش</th>
                            <th>نوعیت سفارش</th>
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
                            data-target="#collapse{{ $order->order_id }}" aria-expanded="false"
                            aria-controls="collapseOne">
                        سفارش : {{ $order->name .' - '.'نمبر سفارش'. ' '.$order->identity }}
                    </button>

                    @if($order->status=='1')
                        <button id="send_order" class="btn btn-primary btn-xs"
                                order_id="{{$order->order_id}}" onclick="sendOrder(this)" style="float: left">ارسال<i id="send_icon"></i>
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

                            <th>تعداد سفارش</th>
                            <th>نوعیت سفارش</th>
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
                            <th>تعداد سفارش</th>
                            <th>نوعیت سفارش</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div> <!-- /card -->

    @endif

@endforeach