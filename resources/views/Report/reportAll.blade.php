@extends('dashboard.layouts.app')
@section('main_content')

    <div class="container-fluid pt-5">
        <h3 style="text-align: center; margin-bottom:40px " id="title">گزارش فروشات کلی</h3>
        <form action="{{route('getReportAll')}}" id="report">
            <div class="row">
                <div class="col-md-2">
                    <label for="reason">نوع سفارش:*</label>
                    <select name="reason" id="reason" class="form-control select2_1">
                        <option value="all">همه سفارشات</option>
                        <option value="1">سفارشات داخلی</option>
                        <option value="2">سفارشات بیرونی</option>
                    </select>
                </div> <!-- /col -->
                <div class="col-md-2" id="menu_type">
                    <label for="menu">انتخاب کتگوری</label>
                    <select id="menu" name="menu" class="form-control">
                        <option value="all">همه موارد</option>
                        @foreach($categories as $cat)
                            <option value="{{$cat->category_id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div> <!-- /col -->
                <div class="col-md-2">
                    <label for="type">بر اساس:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="daily">امروز</option>
                        <option value="month">ماه</option>
                        <option value="bt_date">بین تاریخ</option>
                    </select>
                </div> <!-- /col -->
                <div class="col-md-2" id="month_report" style="display: none">
                    <div class="form-group ">
                        <label for="month_r">انتخاب ماه:</label>
                        <select id="month_r" name="month_r" class="form-control">
                            <option value="1">حمل</option>
                            <option value="2">ثور</option>
                            <option value="3">جوزا</option>
                            <option value="4">سرطان</option>
                            <option value="5">اسد</option>
                            <option value="6"> سنبله</option>
                            <option value="7"> میزان</option>
                            <option value="8"> عقرب</option>
                            <option value="9"> قوس</option>
                            <option value="10"> جدی</option>
                            <option value="11"> دلو</option>
                            <option value="12"> حوت</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-2" style="display: none;" id="as_date">
                    <div class="form-group ">
                        <label for="start_date" class="control-label ">از تاریخ:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="روز/ماه/سال" id="jalali-startdate"
                                   name="start_date" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="display: none;" id="to_date">
                    <div class="form-group " id="year">
                        <label for="end_date" class="control-label ">تا تاریخ:*</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="روز/ماه/سال" id="jalali-datepicker"
                                   name="end_date" autocomplete="off">
                        </div>

                    </div>
                </div>


                <div class="col-md-2 expense_report">
                    <button id="get-report" type="button" class="btn btn-info btn-rounded">
                        گرفتن گزارش&nbsp;<i class="report_icon"></i></button>
                </div>
                <div class="col-md-2" style="margin-top: 30px">
                    <button class="btn btn-primary btn-rounded" id="print_butt"> پرنت <i class="fa fa-print"></i>
                    </button>
                </div>

            </div>
        </form>
        <div class="row">


            <div class="col-md-12">
                <table id="print_table" style="display:none; width: 100%">
                    <tr>
                        <td>نوع گزارش: <span id="expense_print"></span></td>
                        <td> بر اساس: <span id="type_print"></span></td>
                        <td id="month">ماه: <span id="month_print"></span></td>
                        <td id="from">از تاریخ: <span id="from_print"></span></td>
                        <td id="to">تا: <span id="to_print"></span></td>

                    </tr>
                </table>
            </div>
            <div class="col-md-12" style="margin-top: 20px; overflow-x: auto">

                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="sum">

                    <tr>
                        <th>شماره</th>
                        <th>نوع سفارش</th>
                        <th>تعداد</th>
                        <th>قیمت فی</th>
                        <th> قیمت کل</th>
                        <th> تاریخ</th>
                    </tr>
                    </thead>


                    <tbody id="content-display">


                    </tbody>


                </table>
                <table class="table table-striped table-bordered" style="text-align: right; width: 100% !important;" id="footer">
                    <tr>
                        <th>مجموع سفارشات بیرونی</th>
                        <th class="total_out">0</th>
                        <th>مجموع سفارشات داخلی</th>
                        <th class="total_in">0</th>
                        <th>مجموع کل</th>
                        <th class="total">0</th>

                    </tr>
                    <tr>
                        <th>تخفیف بیرونی</th>
                        <th class="discount_out">0</th>
                        <th>تخفیف داخلی</th>
                        <th class="discount_in">0</th>
                        <th>مجموع تخفیفات</th>
                        <th class="discount">0</th>
                    </tr>
                    <tr>
                        <th colspan="3">عواید نهایی</th>
                        <th colspan="3" class="final_income">0</th>

                    </tr>
                </table>

                <div class="pagination" style="float: left" id="pagination">

                </div>
            </div>

        </div>


    </div>

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

        @media print {
            body, div.fixed-navbar {
                visibility: hidden !important;
            }

            form {
                display: none;
            }

            h3 {
                visibility: visible !important;
                margin-bottom: 30px !important;
            }

            #footer {
                visibility: visible !important;

            }

            h3.page-title {
                visibility: hidden !important;
            }

            @page {

                margin: 0 !important;

            }

            .container, .row {
                padding: 0 !important;
            }

            #print_table {
                visibility: visible !important;

                margin-right: 30px !important;
                display: block !important;
                z-index: 1000 !important;
                position: absolute !important;
            }

            #example {
                visibility: visible !important;
                margin-top: 10px !important;
                position: relative !important;
                padding: 0 !important;
            }

            td > span {
                padding-left: 20px !important;
            }

        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#print_butt').on('click', function (e) {
                e.preventDefault();
                window.print()
            })
            $(document).off("click");
            $('#get-report').on('click', function (e) {
                e.preventDefault();

                var data = $("#report").serialize();
                var url = $("#report").attr('action');


                $('#month_print').text($('#month_r option:selected').text())
                $('#from_print').text($('#jalali-startdate').val())
                $('#to_print').text($('#jalali-datepicker').val())

                $('#expense_print').text($('#reason option:selected').text())
                //
                var type = $('#type').val();
                if (type == 'bt_date') {
                    $('#type_print').text("بین تاریخ")
                    $('td#month').css('display', "none");
                    $('td#from').css('display', "block");
                    $('td#to').css('display', "revert");
                }

                if (type == 'month') {
                    $('#type_print').text('ماهانه')
                    $('td#to').css('display', "none");
                    $('td#from').css('display', "none");
                    $('td#month').css('display', "block");
                }
                if (type == 'daily') {
                    $('#type_print').text('امروز')
                    $('td#to').css('display', "none");
                    $('td#from').css('display', "none");
                    $('td#month').css('display', "none");
                }

                $(".report_icon").addClass('fa fa-spinner fa-spin');
                $('.loading').show();

                // var Post = $(this).attr('method');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        var table = "";

                        console.log(response)
                        if (response.data.length > 0 || response.data_out.length > 0) {
                            var count = 1;
                            if (response.type == 'all') {
                                for (var i = 0; i < response.data.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data[i].menu_name + '</td>' +
                                        '<td>' + response.data[i].or_am + '</td>' +
                                        '<td>' + response.data[i].price + '</td>' +
                                        '<td>' + response.data[i].total_price + '</td>' +
                                        '<td>' + moment(response.data[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD') + '</td>' +
                                        '</tr>';
                                    count++;
                                }
                                for (var i = 0; i < response.data_out.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data_out[i].menu_name + '</td>' +
                                        '<td>' + response.data_out[i].or_am + '</td>' +
                                        '<td>' + response.data_out[i].price + '</td>' +
                                        '<td>' + response.data_out[i].or_am * response.data_out[i].price + '</td>' +
                                        '<td>' + moment(response.data_out[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD') + '</td>' +
                                        '</tr>';
                                    count++;
                                }
                            }
                            if (response.type == 1) {
                                for (var i = 0; i < response.data.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data[i].menu_name + '</td>' +
                                        '<td>' + response.data[i].or_am + '</td>' +
                                        '<td>' + response.data[i].price + '</td>' +
                                        '<td>' + response.data[i].total_price + '</td>' +
                                        '<td>' + moment(response.data[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD') + '</td>' +
                                        '</tr>';
                                    count++;
                                }
                            }
                            if (response.type == 2) {
                                for (var i = 0; i < response.data.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data[i].menu_name + '</td>' +
                                        '<td>' + response.data[i].or_am + '</td>' +
                                        '<td>' + response.data[i].price + '</td>' +
                                        '<td>' + response.data[i].or_am * response.data[i].price + '</td>' +
                                        '<td>' + moment(response.data[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD') + '</td>' +
                                        '</tr>';
                                    count++;
                                }
                            }

                        } else {
                            table += '<tr><td colspan="6" class="text-center">اطلاعاتی برای نمایش وجود ندارد</td></tr>'
                        }
                        $(".report_icon").removeClass('fa fa-spinner fa-spin');
                        $('.loading').hide();

                        $('#content-display').html(table);
                        $('#pagination').html(response['pagination']);

                        $(".total_in").text(response.sum);
                        $(".total_out").text(response.sum_out);
                        $(".total").text(parseInt(response.sum_out) + parseInt(response.sum));
                        $(".discount").text(parseInt(response.discount) + parseInt(response.discount_out));
                        $(".discount_out").text(response.discount_out);
                        $(".discount_in").text(response.discount);
                        $(".final_income").text((parseInt(response.sum_out) + parseInt(response.sum)-(parseInt(response.discount) + parseInt(response.discount_out))));

                        $(".dt-button").addClass("btn");


                    }

                });

            });

        });

        $(document).ready(function () {
            //   JALALI DATEPICKER
            // * ===============*/
            var opt = {

                // placeholder text

                placeholder: "",

                // enable 2 digits

                twodigit: true,

                // close calendar after select

                closeAfterSelect: true,

                // nexy / prev buttons

                nextButtonIcon: "fa fa-forward",

                previousButtonIcon: "fa fa-backward",

                // color of buttons

                buttonsColor: "پیشفرض ",

                // force Farsi digits

                forceFarsiDigits: true,

                // highlight today

                markToday: true,

                // highlight holidays

                markHolidays: false,

                // highlight user selected day

                highlightSelectedDay: true,

                // true or false

                sync: false,

                // display goto today button

                gotoToday: true

            }

            kamaDatepicker('jalali-datepicker', opt);
            kamaDatepicker('jalali-startdate', opt);
            $('.select2_1').select2();

        });

        /**  report js**/
        $(function () {
            $('#year_r').hide();
            $('#month').hide();
            $('#bt_date').hide();

            $('#between_date').hide();
            $('#get-report').css('margin-top', '30px');

            $('#type').change(function () {

                if ($('#type').val() == 'month') {
                    $('#to_date').hide();
                    $('#as_date').hide();
                    $('#month_report').show();
                    $('#get-report').css('margin-top', '30px');
                    $('#get-report').css('margin-bottom', '0px');
                    $('h3#title').removeClass('tb_title')
                    $('table#print_table').removeClass('bt_print_table')
                    $('table#example').removeClass('bt_example')


                } else if ($('#type').val() == 'bt_date') {
                    $('#month_report').hide();
                    $('#as_date').show();
                    $('#to_date').show();
                    $('h3#title').addClass('tb_title')
                    $('table#print_table').addClass('bt_print_table')
                    $('table#example').addClass('bt_example')

                } else if ($('#type').val() == 'daily') {
                    $('#month_report').hide();
                    $('#as_date').hide();
                    $('#to_date').hide();
                    $('h3#title').addClass('tb_title')
                    $('table#print_table').addClass('bt_print_table')
                    $('table#example').addClass('bt_example')

                } else {
                    $('#selection').hide();
                }
            });


        });


    </script>
@endsection