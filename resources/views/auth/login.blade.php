<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/custom/custom.css') }}">
</head>
<body>

<div class="main auth_mail">

    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="{{ asset('/images/signin-image.jpg') }}" alt="sing up image"></figure>
                    <a href="{{ route('register') }}" class="signup-image-link"> ثبت نام </a>
                </div>

                <div class="signin-form validation">
                    <h2 class="form-title"> فرم ورودی </h2>
                    <form method="POST"
                          class="register-form"
                          id="login-form"
                          action="{{ route('authenticateLogin') }}"
                    >

                        @csrf
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="email" name="email" autocomplete="off" id="email" placeholder="ایمیل آدرس"/>
                            @error('email')<span style="color: red !important;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="your_pass" autocomplete="off" id="your_pass" placeholder="پسورد"/>
                            @error('your_pass')<span style="color: red !important;">{{ $message }}</span>@enderror

                        </div>
                        @if (session('message'))
                            <div class="alert alert-danger" style="color: red !important;; font-size: 20px">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="ورود"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- JS -->
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/main.js') }}"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>