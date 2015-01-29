@extends('layout')

@section('content')
<h1 class="form-header">Welcome to Android-Libs!</h1>


<!-- Form -->
<form action="{{ url('/register') }}" id="signup-form" class="panel" method="post">
    <div class="form-group">
        <input type="text" name="email" id="email" class="form-control input-lg" placeholder="E-mail">
    </div>

    <div class="form-group">
        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
    </div>

    <div class="form-group">
        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
    </div>

    <div class="form-group">
        <input type="password" name="password_repeat" id="password_repeat" class="form-control input-lg" placeholder="Repeat Password">
    </div>

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="newsletter" class="px" id="newsletter" checked>
            <span class="lbl">Send me E-Mails from Android-Libs.com</span>
        </label>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg btn-block btn-labeled margin-bottom-20">
            <span class="btn-label icon fa fa-check"></span> Create an account
        </button>
        <p class="text-muted text-center margin-bottom-20">OR</p>
        <a href="{{ url('/login/github') }}" class="btn btn-default btn-lg btn-block btn-labeled">
            <span class="btn-label icon fa fa-github-alt"></span> Sign up with GitHub
        </a>
    </div>
</form>
<!-- / Form -->

{{--<div class="signup-with">
    <div class="header">or sign up with</div>
    <a href="index.html" class="btn btn-lg btn-facebook rounded"><i class="fa fa-facebook"></i></a>&nbsp;&nbsp;
    <a href="index.html" class="btn btn-lg btn-info rounded"><i class="fa fa-twitter"></i></a>&nbsp;&nbsp;
    <a href="index.html" class="btn btn-lg btn-danger rounded"><i class="fa fa-google-plus"></i></a>
</div>--}}

<!-- Site Scripts -->
<script type="text/javascript">
	init.push(function () {
			$("#signup-form").validate({
			    focusInvalid: true,
			    rules: {
                    'email': {
                        required: true,
                        email: true
                    },
                    'username': {
                        required: true,
                        minlength: 3
                    },
                    'password': {
                        required: true,
                        minlength: 6
                    },
                    'password_repeat': {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    }
			    }
            });
		}
	);
</script>

@stop