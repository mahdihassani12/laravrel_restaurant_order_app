@extends('dashboard.layouts.app')
@section('main_content')

    <div class="container-fluid pt-5">
        <h3 style="text-align: center; margin-bottom:40px " id="title">گزارش فروشات بیرونی</h3>
        <form action="{{route('getOutsideReport')}}" id="report">
            <div class="row">
                <div class="col-md-3">
                    <label for="reason">نوع گزارش:*</label>
                    <select name="reason" id="reason" class="form-control select2_1">
                        <option value="1">بر اساس بیشترین فروش</option>
                        <option value="2">بر اساس مینو</option>
                    </select>
                </div> <!-- /col -->
                <div class="col-md-2" id="menu_type">
                    <label for="menu">انتخاب کتگوری</label>
                    <select id="menu" name="menu" class="form-control">
                        @foreach($categories as $cat)
                            <option value="{{$cat->category_id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div> <!-- /col -->
                <div class="col-md-2">
                    <label for="type">بر اساس:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="month">ماه</option>
                        <option value="bt_date">بین تاریخ</option>
                    </select>
                </div> <!-- /col -->
                <div class="col-md-3" id="month_report">
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
            <div class="col-md-12" style="margin-top: 20px;">

                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="sum">
                    <tr>
                        <th>مجموعه</th>
                        <th class="total" colspan="5">0</th>
                    </tr>
                    <tr>
                        <th>شماره</th>
                        <th>نوع سفارش</th>
                        <th>تعداد</th>
                        <th>قیمت فی</th>
                        <th> قیمت کل</th>
                        <th> تاریخ</th>
                    </tr>
                    </thead>
                    <tfoot style="text-align: right">

                    </tfoot>

                    <tbody id="content-display">


                    </tbody>
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

            h3 {
                visibility: visible !important;
                margin-bottom: 30px !important;
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
                margin-top: -50px !important;
                margin-right: 30px !important;
                display: block !important;
                z-index: 1000 !important;
                position: absolute !important;
            }

            #example {
                visibility: visible !important;
                margin-top: -40px !important;
                position: relative !important;
                padding: 0 !important;
            }

            td > span {
                padding-left: 20px !important;
            }

            .bt_print_table {
                margin-top: -780px !important;

            }

            #bt_example {

                margin-top: -500px !important;

            }

            .tb_title {
                margin-bottom: -90px !important;
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

                        console.log(response.data)
                        if (response.data.length > 0) {
                            var count = 1;
                            if (response.type==1){
                                for (var i = 0; i < response.data.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data[i].menu_name + '</td>' +
                                        '<td>' + response.data[i].or_am + '</td>' +
                                        '<td>' + response.data[i].price + '</td>' +
                                        '<td>' + response.data[i].total_price + '</td>' +
                                        '<td>' + moment(response.data[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD')+ '</td>'+
                                        '</tr>';
                                    count++;
                                }
                            }
                            else{
                                for (var i = 0; i < response.data.length; i++) {
                                    table += '<tr>' +
                                        '<td>' + (count) + '</td>' +
                                        '<td>' + response.data[i].menu_name + '</td>' +
                                        '<td>' + response.data[i].or_am + '</td>' +
                                        '<td>' + response.data[i].price + '</td>' +
                                        '<td>' + response.data[i].or_am*response.data[i].price + '</td>' +
                                        '<td>' + moment(response.data[i].created_at, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD')+ '</td>'+
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

                        $(".total").text(response.sum)

                        $(".dt-button").addClass("btn");


                    }

                });

            });

        });

        $(document).ready(function () {
            //   JALALI DATEPICKER
            / * ===============*/
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
            $('#menu_type').hide();
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

                } else {
                    $('#selection').hide();
                }
            });

            //type report according to more sale or category
            $('#reason').change(function () {

                if ($('#reason').val() == 1) {
                    $('#menu_type').hide();


                } else if ($('#reason').val() == 2) {
                    $('#menu_type').show();

                } else {
                    $('#selection').hide();
                }
            });
        });






    </script>
@endsection