@extends('Payment.layouts.app')
@section('main_content')

    لست پرداختی های داخلی

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
    </style>
@endsection

@section('script')
    <script type="text/javascript"></script>
@endsection