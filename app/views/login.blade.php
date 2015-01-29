@extends('layout')

@section('content')
<h1 class="form-header">Sign in to your Account</h1>


<!-- Form -->
<form action="{{ url('/login') }}" id="signin-form" method="post" class="panel">
    <div class="form-group">
        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
    </div> <!-- / Username -->

    <div class="form-group signin-password">
        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
        {{-- TODO <a href="#forgot-pw-modal" data-toggle="modal" class="forgot">Forgot?</a>--}}
    </div> <!-- / Password -->

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="remember" class="px" id="remember">
            <span class="lbl">Remember me</span>
        </label>
    </div> <!-- / Remember -->


    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg btn-block btn-labeled margin-bottom-20">
            <span class="btn-label icon fa fa-sign-in"></span> Sign in
        </button>
        <p class="text-muted text-center margin-bottom-20">OR</p>
        <a href="{{ url('/login/github') }}" class="btn btn-default btn-lg btn-block btn-labeled">
            <span class="btn-label icon fa fa-github-alt"></span> Sign in with GitHub
        </a>
    </div> <!-- / .form-actions -->
</form>
<!-- / Form -->

{{--<div class="signin-with">
    <div class="header">or sign in with</div>
    <a href="index.html" class="btn btn-lg btn-facebook rounded"><i class="fa fa-facebook"></i></a>&nbsp;&nbsp;
    <a href="index.html" class="btn btn-lg btn-info rounded"><i class="fa fa-twitter"></i></a>&nbsp;&nbsp;
    <a href="index.html" class="btn btn-lg btn-danger rounded"><i class="fa fa-google-plus"></i></a>
</div>--}}


<!-- Modals -->
<div id="forgot-pw-modal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-sm">
        <form method="post" action="{{ url('/forgot/password') }}" id="forgot-pw-form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Forgot your password?</h4>
                </div>
                <div class="modal-body">
                    <strong>Oh no!</strong>
                    <br>
                    But no worries, we can help you.
                    <br>
                    Just give us your E-Mail:
                    <br><br>
                    <div class="form-group">
                        <label for="forgot-email">E-Mail</label>
                        <input type="email" class="form-control" name="email" id="forgot-email" placeholder="info@example.org">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-forgot-pw-submit btn-labeled">
                        <span class="btn-label icon fa fa-send"></span> Send me my password!
                    </button>
                </div>
            </div> <!-- / .modal-content -->
        </form>
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->
<!-- / Small modal -->



<!-- Site Scripts -->
<script type="text/javascript">
	init.push(function () {
        // Validate form
        $('#signin-form').validate({
           focusInvalid: true,
           rules: {
               'username': {
                   required: true
               },
               'password': {
                   required: true,
                   minlength: 6
               }
           }
        });

        $('#forgot-pw-form').validate({
            focusInvalid: true,
            rules: {
                'email': {
                    required: true,
                    email: true
                }
            }
        });
    });
</script>

@stop