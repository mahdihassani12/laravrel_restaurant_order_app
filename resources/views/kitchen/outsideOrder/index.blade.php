@extends('Kitchen.layouts.app')
@section('main_content')

    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">لیست سفارشات بیرونی</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table id="example" class="table table-condensed table-bordered">
                            <thead>
                            <tr>
                                <td>شماره</td>
                                <td>نمبر سفارش</td>
                                <td>شماره میز</td>
                                <td>نوع غذا</td>
                                <td>تعداد غذا</td>
                                <td>عملیات</td>
                            </tr>
                            </thead>
                            <tbody id="orders">
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$order->identity}}</td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->menu_name}}</td>
                                    <td>{{$order->order_amount}}</td>
                                    <td>
                                        @if($order->status=='1')
                                        <button id="send_order" class="btn btn-primary btn-xs" order_id="{{$order->order_id}}">ارسال<i id="send_icon"></i></button>
                                        @else
                                            <button class="btn btn-success btn-xs" disabled>ارسال شده</button>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>شماره</td>
                                <td>نمبر سفارش</td>
                                <td>شماره میز</td>
                                <td>نوع غذا</td>
                                <td>تعداد غذا</td>
                                <td>عملیات</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

@endsection

@section('style')
    <style>
        .alert{
            position: fixed;
            bottom: 0;
            z-index: 10;
            left: 20px;
        }
        .alert button{
            margin-left: 5px;
        }
        .fa-edit{
            color:blue;
        }
        .fa-trash{
            color:red;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            //refresh table after 30 seconds to see the new order
            // setInterval(function(){
                $.ajax({
                    url:'{{route('getOrders')}}',
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                        console.log(response)
                        if(response.orders.length>0){
                            var orders ='';
                            $.each(response.orders, function (i, item) {
                                orders += '<tr><td>' + (++i) + '</td><td>' + item.identity + '</td><td>' + item.name + '</td><td>' + item.menu_name + '</td><td>' + item.order_amount + '</td>' +
                                    '<td id="operations">';
                                if (item.status=='1'){
                                    orders += '<button type="button" id="send_order" order_id="' + item.total_id + '" class="btn btn-primary bt-xs">ارسال<i id="send_icon"></i></button>' ;

                                }
                                else{
                                    orders += '<button class="btn btn-success btn-xs" disabled>ارسال شده</button>';
                                }
                                orders +=  '</td>'+
                                '</tr>';

                            });
                            $('#orders').empty();
                            $('#orders').append(orders);
                        }
                    },error:function(err){

                    }
                })
            // }, 30000);


            //send order from kitchen

            $('#example tbody').on('click', 'button', function () {
                var order_id = $(this).attr("order_id");

                $.ajax({
                    url:'{{route('sendOrders')}}',
                    type:'GET',
                    dataType:'json',
                    data:{
                        'id':order_id
                    },
                    success:function(response){
                        if (response){
                            alert('ارسال شد!');
                                window.location.reload();
                        }
                      else{
                            alert('ارسال نشد!')
                        }

                    },error:function(err){


                    }
                })

            });
        });
    </script>
@endsection