<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-rtl.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/custom/custom.css') }}">
</head>
<body>

    <div class="main auth_mail">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form validation">
                        <h2 class="form-title"> فرم ثبت نام </h2>
                        <form method="POST" action="{{ route('storeUser') }}" 
                                            class="register-form" id="register-form">

                             @csrf               
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" autocomplete="off" placeholder="نام"/>
                                @error('name')<span>{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" autocomplete="off" 
                                       placeholder="ایمیل آدرس"/>
                                @error('email')<span>{{ $message }}</span>@enderror
                            </div>
							<div class="form-group">
								<label for="role"><i class="zmdi zmdi-layers"></i></label>
								<select name="role" id="role">
									<option value=" "> انتخاب نقش کاربری </option>
									<option value="admin"> مدیر  کل </option>
									<option value="kitchen"> آشپزخانه </option>	
									<option value="accountant"> حسابداری </option>	
									<option value="order"> ثبت سفارش </option>	
								</select>
                                @error('role')<span>{{ $message }}</span>@enderror
							</div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" autocomplete="off" 
                                       placeholder="پسورد"/>
                                @error('pass')<span>{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="ثبت نام"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('/images/signup-image.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ route('login') }}" class="signup-image-link">عضو هستم</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/main.js') }}"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>