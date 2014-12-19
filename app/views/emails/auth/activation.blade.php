<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AndroidLibs</title>

    <!-- Bootstrap CSS served from a CDN -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://bootswatch.com/flatly/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    {{ HTML::style('assets/css/template-email.css') }}
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <br>
                <h3>Please activate your account at <a href="{{ url('/') }}">Android-Libs.com</a>! :-)</h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="email-icon text-success">
                            <i class="fa fa-fw fa-5x fa-envelope"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <p>
                            <strong>Hello.</strong> Thank you for registration on Android-Libs.com!
                        </p>
                        <p>
                           In order to use Android-Libs and its functionality, you have to activate your account.
                        </p>
                        <p>
                            To activate your account click on the following link or open it in your favorite browser:
                        </p>
                        <p>
                            <a href="{{ url('/activate/' . $userId . '/' . $code) }}">Activate my account</a>
                        </p>
                        <br><br>
                        <p class="text-muted">&mdash; Alexander, creator of AndroidLibs &mdash;</p>
                    </div>
                </div>
                <hr>
                <p>
                    <a href="{{ url('/') }}" class="btn btn-block btn-primary" target="_blank"><i class="fa fa-fw fa-globe"></i> Check it out on Android-Libs.com!</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>