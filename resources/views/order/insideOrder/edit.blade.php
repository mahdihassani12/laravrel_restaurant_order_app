@extends('order.layouts.app')
@section('main_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark text-center"> ویرایش سفارشات داخلی </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <section id="tabs" class="project-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    @foreach($categories as $key=> $category)
                                        <a @if($category->category_id==1)class="nav-item nav-link active"
                                           @else class="nav-item nav-link" @endif id="nav-home-tab" data-toggle="tab"
                                           href="#food{{$key}}" category_id = "{{$category->category_id}}"
                                           role="tab" aria-controls="nav-home"
                                           aria-selected="true">{{$category->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="food" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    <table class="table" cellspacing="0" id="example">
                                        <thead>
                                        <tr>
                                            <th>نام</th>
                                            <th>قیمت</th>
                                            <th>تعداد</th>
                                            <th>پروسس</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @foreach($menu as $index => $f)
                                            <tr>

                                                <td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
                                                <td style="width: 18% !important;" id="price">{{ $f-> price }}</td>
                                                <td style="width: 18% !important;" id="amount">
                                                    <input type="number"
                                                           name="amount"
                                                           id="amount"
                                                           class="amount"
                                                           value="1"
                                                           placeholder="تعداد"
                                                    />
                                                </td>
                                                <td style="width: 18% !important;" class="process ">
                                                    <button class="fa fa-plus"></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>نام</th>
                                            <th>قیمت</th>
                                            <th>تعداد</th>
                                            <th>پروسس</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> <!--/col-->
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">سفارش</div>
                <div class="card-body">
                    <form id="order" method="post" action="{{ route('updateInsideOrder',$t_orders->order_id) }}">
                        {{isset($shop) ?method_field('put'):''}}
                        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                        <table class="table table-bordered">
                            <tr>
                                <th> نام</th>
                                <th> تعداد</th>
                                <th> قیمت فی</th>
                                <th> لغو</th>
                            </tr>
                            @foreach($orders as $key => $order)
                                <tr class="order_row">
                                    <td id="order_name"><span>{{$order->menu_name}}</span></td>
                                    <input type="hidden" name="menu_id_field[]" id="menu_id_field"
                                           value="{{$order->menu_id}}">
                                    <td id="order_amount"><span>{{$order->order_amount}}</span></td>
                                    <input type="hidden" name="order_amount_field[]" id="order_amount_field"
                                           value="{{$order->order_amount}}">
                                    <td id="order_price"><span>{{$order->price}}</span></td>
                                    <input type="hidden" name="order_price_field[]" id="order_price_field"
                                           value="{{$order->price}}">
                                    <td class="order_cancel" onclick="this.parentElement.remove()">
                                        <span class="fa fa-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <div class="form-group">
                            قیمت کل : <span
                                    class="total_price">{{isset($t_orders)?$t_orders->total:''}}  </span>
                            <input type="hidden" name="total_payment" id="total_payment"
                                   value="{{isset($t_orders)?$t_orders->total:''}}">
                        </div>
                        <input type="hidden" id="identity" name="identity" value="{{isset($t_orders)?$t_orders->identity:''}}">
                        <input type="hidden" id="id" name="id" value="{{isset($t_orders)?$t_orders->order_id:''}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="table_name" id="table_name" class="form-control">
                                        @foreach($tables  as $tb)
                                            <option value="{{$tb->location_id}}"{{isset($t_orders)&&$t_orders->location_id==$tb->location_id ? 'selected'.'='. 'selected':'' }}>{{$tb->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success btn-xs pull-left" id="submit_order">ارسال</button>
                            </div>
                            <div class="form-group" id="er_mssages">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div> <!--/card-body-->
            </div>
        </div>
    </div> <!--/col-->


@endsection

@section('style')
    <style>
        #er_mssages {
            clear: both;
        }

        .tab-content input#amount {
            width: 100%;
        }

        .fa-minus, .fa-plus {
            cursor: pointer;
        }

        .process {
            cursor: pointer
        }

        .card-body {
            padding: 0.5rem;
        }

        #order .form-group {
            display: flex;
        }

        #order .form-group .count {
            margin: 0 5px;
            padding-top: 5px;
        }

        #order .form-group .price {
            margin: 0 5px;
            padding-top: 5px;
        }

        .project-tab {

        }

        .project-tab #tabs {
            background: #007b5e;
            color: #eee;
        }

        .project-tab #tabs h6.section-title {
            color: #eee;
        }

        .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #0062cc;
            background-color: transparent;
            border-color: transparent transparent #f3f3f3;
            border-bottom: 3px solid !important;
            font-size: 16px;
            font-weight: bold;
        }

        .project-tab .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #0062cc;
            font-size: 16px;
            font-weight: 600;
        }

        .project-tab .nav-link:hover {
            border: none;
        }

        .project-tab thead {
            background: #f3f3f3;
            color: #333;
        }

        .project-tab a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

        .tab-content table {
            display: table;
        }

        .tab-content table th, .tab-content table td {
            display: table-cell;
            max-width: 0;
            text-align: center;
        }

        #discount {
            width: 70px;
        }

        .order_cancel span {
            color: red;
            cursor: pointer;
        }

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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('a.nav-item').click(function () {

                var id=$(this).attr('category_id')
                $.ajax({
                    type: "GET",
                    url: "{{route('order.getMenu')}}",
                    data: {
                        'id':id
                    },
                    success: function (msg) {
                        $("#tbody").empty();
                        $("#tbody").html(msg);

                    }
                });
            })

            var total = 0;
            $('#example').on('click','.process',function () {

                var order_name = jQuery(this).siblings('#name').text();
                var order_id = jQuery(this).siblings('#name').attr('menu_id');
                var order_price = jQuery(this).siblings('#price').text();
                var order_amount = jQuery(this).siblings('#amount').children('input#amount').val();
                var total_price = $('.total_price').text();

                jQuery('#order table').append(
                    '<tr class="order_row">'
                    + '<td id="order_name">'
                    + '<input type="hidden" name="menu_id_field[]" id="menu_id_field" class="menu_id_field" value=' + order_id + '>'
                    + '<span>' + order_name + '</span>'
                    + '</td>'
                    + '<td id="order_amount">'
                    + '<span>' + order_amount + '</span>'
                    + '<input type="hidden" name="order_amount_field[]" id="order_amount_field" class="order_amount_field" value=' + order_amount + '>'
                    + '</td>'
                    + '<td id="order_price">'
                    + '<span>' + order_price + '</span>'
                    + '<input type="hidden" name="order_price_field[]" id="order_price_field" class="order_price_field" value=' + order_price + '>'
                    + '</td>'
                    + '<td class="order_cancel" onclick="this.parentElement.remove()">'
                    + '<span class="fa fa-trash"><span>'
                    + '</td>'
                    + '</tr>'
                ); // append to the form

                total = ((order_amount * order_price) + parseInt(total_price));
                $(".total_price").html(total);
                $('#total_payment').val(total)

            }); // end or process order function

            jQuery(document).on('click', '.order_cancel', function () {

                var order_price = jQuery(this).siblings('#order_price').children('span').text();
                var order_amount = jQuery(this).siblings('#order_amount').children('span').text();
                var total_price = $('.total_price').text();

                total = (parseInt(total_price) - (order_amount * order_price));

                $("span.total_price").html(total);
                $('#total_payment').val(total)
            });
            jQuery("#table_order").select2({
                dir: "rtl"
            });


            $('form#order').submit(function (eventObj) {
                $(this).append('<input type="hidden" name="total" value="' + total + '" /> ');
                return true;
            });

        });

    </script>
@endsection