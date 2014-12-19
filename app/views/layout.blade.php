<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="Android-Libs" />
    <meta name="author" content="Alexander Mahrt" />
    <meta name="distributor" content="" />
    <meta name="robots" content="All" />
    <meta name="description" content="Android-Libs is a portal with hundreds of android libraries and tools for developers." />
    <meta name="keywords" content="android,libraries,libs,dev,developer,list" />
    <meta name="rating" content="General" />
    <meta name="dcterms.title" content="Android-Libs" />
    <meta name="dcterms.contributor" content="Alexander Mahrt" />
    <meta name="dcterms.creator" content="Alexander Mahrt" />
    <meta name="dcterms.publisher" content="Alexander Mahrt" />
    <meta name="dcterms.description" content="Android-Libs is a portal with hundreds of android libraries and tools for developers." />
    <meta name="dcterms.rights" content="Alexander Mahrt" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Android-Libs" />
    <meta property="og:description" content="Android-Libs is a portal with hundreds of android libraries and tools for developers." />
    <meta property="twitter:title" content="Android-Libs" />
    <meta property="twitter:description" content="Android-Libs is a portal with hundreds of android libraries and tools for developers." />
    <link href="{{ asset('/assets/img/favicon.ico') }}" rel="icon" type="image/x-icon" />
    <title>Android-Libs - your portal for android libraries and tools</title>

    <!-- Bootstrap CSS served from a CDN -->
    {{ Assets::css() }}

    <script>
        var baseUrl = "{{ url('/') }}";
        var init = [];
    </script>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-52515505-1', 'auto');
        ga('set', 'anonymizeIp', true);
        ga('send', 'pageview');

    </script>
</head>

@if($page == 'login')
<body class="theme-clean no-main-menu page-signin-alt">
@elseif($page == 'register')
<body class="theme-clean no-main-menu page-signup-alt">
@else
@yield('body', '<body class="no-main-menu theme-clean dont-animate-mm-content-sm animate-mm-md animate-mm-lg">')
@endif
<div id="main-wrapper">


    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
    <!-- Main menu toggle -->
    <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span>
    </button>

    <div class="navbar-inner">
    <!-- Main navbar header -->
    <div class="navbar-header">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="navbar-brand">
            <div><img alt="Pixel Admin" src="{{ asset('/assets/img/navbar_logo.png') }}"></div>
            Android-Libs
        </a>

        <!-- Main navbar toggle -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i
                class="navbar-icon fa fa-bars"></i></button>

    </div>
    <!-- / .navbar-header -->

    <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
    <div>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"><i class="fa fa-fw fa-list"></i> LIBRARIES <i class="fa fa-fw fa-caret-down"></i></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ url('/featured') }}"><i class="fa fa-fw fa-star"></i> Featured</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ url('/') }}"><i class="fa fa-fw fa-search"></i> All</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/submit') }}"><i class="fa fa-fw fa-envelope"></i> SUBMIT</a>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"><i class="fa fa-fw fa-share-alt"></i> SHARE</a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="sharrre-counters facebook btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/') }}" data-share="facebook">
                        <i class="fa fa-fw fa-facebook"></i> Facebook
                    </a>
                </li>
                <li>
                    <a href="#" class="sharrre-counters twitter btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/') }}" data-share="twitter">
                        <i class="fa fa-fw fa-twitter"></i> Twitter
                    </a>
                </li>
                <li>
                    <a href="#" class="sharrre-counters gplus btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/') }}" data-share="gplus">
                        <i class="fa fa-fw fa-google-plus"></i> Google+
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#creditModal" data-toggle="modal">
                <i class="fa fa-fw fa-star"></i> CREDITS
            </a>
        </li>
        <li>
            <a href="https://github.com/Cyruxx/Android-Libs" target="_blank">
                <i class="fa fa-fw fa-github-square"></i> REPO
            </a>
        </li>
        <li>
            <a href="https://gitter.im/Cyruxx/Android-Libs" target="_blank">
                <i class="fa fa-fw fa-comments"></i> CHAT
            </a>
        </li>
        <li>
            <a href="{{ url('/rss') }}" target="_blank">
                <i class="fa fa-fw fa-rss-square"></i> RSS
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="http://twitter.com/AlexMahrt" target="_blank"><i class="fa fa-fw fa-twitter"></i> AlexMahrt</a>
        </li>
        @if( Sentry::check() )
        <li class="dropdown">
            <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                <img src="{{ Sentry::getUser()->getAvatar() }}">
                <span>{{ Sentry::getUser()->username }} <i class="fa fa-fw fa-caret-down"></i> </span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('/user/profile') }}"><i class="fa fa-fw fa-user"></i> Profile</a></li>
                @if( Sentry::getUser()->hasAnyAccess([ 'admin' ]) )
                <li><a href="{{ url('/admin') }}"><i class="fa fa-fw fa-star dropdown-icon"></i> Administration</a></li>
                @endif
                <li class="divider"></li>
                <li><a href="{{ url('/logout') }}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
            </ul>
        </li>
        @else
        <li><a href="{{ url('/login') }}"><i class="fa fa-fw fa-sign-in"></i> Sign in</a></li>
        <li><a href="{{ url('/register') }}"><i class="fa fa-fw fa-check"></i> Sign up</a></li>
        @endif
    </ul>
    <!-- / .navbar-nav -->

    <div class="right clearfix">
    <ul class="nav navbar-nav pull-right right-navbar-nav">

    <!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================

                                Navbar Icon Buttons

                                NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.

                                Classes:
                                * 'nav-icon-btn-info'
                                * 'nav-icon-btn-success'
                                * 'nav-icon-btn-warning'
                                * 'nav-icon-btn-danger'
    -->
    <!-- /3. $END_NAVBAR_ICON_BUTTONS -->
    {{--

    <li>
        <form class="navbar-form search-libs-form pull-left">
            <input type="text" class="form-control" placeholder="Search">
        </form>
    </li>
    --}}



    </ul>
    <!-- / .navbar-nav -->
    </div>
    <!-- / .right -->
    </div>
    </div>
    <!-- / #main-navbar-collapse -->
    </div>
    <!-- / .navbar-inner -->
    </div>


    @include('alerts')
    @yield('content')
    @include('modals.global')
</div>

{{ Assets::js() }}

</body>
</html>