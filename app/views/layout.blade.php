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
    <meta name="description" content="@yield('description', 'Android-Libs is a portal with hundreds of android libraries and tools for developers.')" />
    <meta name="keywords" content="@yield('keywords', 'android libraries for developers,android-libs,android libs,android libraries,android libraries list,android development,android library,android apps,android applications,android projects,android tools,android plugins,free android libraries')" />
    <meta name="rating" content="General" />
    <meta name="dcterms.title" content="Android-Libs" />
    <meta name="dcterms.contributor" content="Alexander Mahrt" />
    <meta name="dcterms.creator" content="Alexander Mahrt" />
    <meta name="dcterms.publisher" content="Alexander Mahrt" />
    <meta name="dcterms.description" content="@yield('description', 'Android-Libs is a portal with hundreds of android libraries and tools for developers.')" />
    <meta name="dcterms.rights" content="Alexander Mahrt" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Android-Libs" />
    <meta property="og:description" content="@yield('description', 'Android-Libs is a portal with hundreds of android libraries and tools for developers.')" />
    <meta property="twitter:title" content="Android-Libs" />
    <meta property="twitter:description" content="@yield('description', 'Android-Libs is a portal with hundreds of android libraries and tools for developers.')" />
    <link href="{{ asset('/assets/img/favicon.ico', true) }}" rel="icon" type="image/x-icon" />
    @yield('title', '<title>Android-Libs - your portal for android libraries and tools</title>')

    <!-- Bootstrap CSS served from a CDN -->
    {{ Assets::css() }}

    <script>
        var baseUrl = "{{ url('/', [], true) }}";
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


    {{--<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
    <!-- Main menu toggle -->
    <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span>
    </button>

    <div class="navbar-inner">
    <!-- Main navbar header -->
    <div class="navbar-header">

        <!-- Logo -->
        <a href="{{ url('/', [], true) }}" class="navbar-brand">
            <div><img alt="Pixel Admin" src="{{ asset('/assets/img/navbar_logo.png', true) }}"></div>
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
                    <a href="{{ url('/featured', [], true) }}"><i class="fa fa-fw fa-star"></i> Featured</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ url('/', [], true) }}"><i class="fa fa-fw fa-search"></i> All</a>
                </li>
	    </ul>
	</li>
        <li>
            <a href="{{ url('/submit', [], true) }}"><i class="fa fa-fw fa-envelope"></i> SUBMIT</a>
        </li>
	    
	
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"><i class="fa fa-fw fa-share-alt"></i> SHARE</a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="sharrre-counters facebook btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/', [], true) }}" data-share="facebook">
                        <i class="fa fa-fw fa-facebook"></i> Facebook
                    </a>
                </li>
                <li>
                    <a href="#" class="sharrre-counters twitter btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/', [], true) }}" data-share="twitter">
                        <i class="fa fa-fw fa-twitter"></i> Twitter
                    </a>
                </li>
                <li>
                    <a href="#" class="sharrre-counters gplus btn-labeled" data-text="Cool library list! @Android_Libs" data-url="{{ url('/', [], true) }}" data-share="gplus">
                        <i class="fa fa-fw fa-google-plus"></i> Google+
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="https://github.com/AndroidLibsCom/Android-Libs" target="_blank">
                <i class="fa fa-fw fa-github-square"></i> REPO
            </a>
        </li>
        <li>
            <a href="https://gitter.im/AndroidLibsCom/Android-Libs" target="_blank">
                <i class="fa fa-fw fa-comments"></i> CHAT
            </a>
        </li>
        <li>
            <a href="{{ url('/rss', [], true) }}" target="_blank">
                <i class="fa fa-fw fa-rss-square"></i> RSS
            </a>
        </li>
	<li>
	    <a href="https://www.pushbullet.com/channel?tag=android-libs" target="_blank">
		<i class="fa fa-fw fa-bullhorn"></i> PUSHBULLET
	    </a>
	</li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		<i class="fa fa-fw fa-group"></i> Social <i class="fa fa-fw fa-caret-down"></i>
	</a>
	<ul class="dropdown-menu" role="menu">
        <li>
            <a href="http://twitter.com/Android_Libs" target="_blank"><i class="fa fa-fw fa-twitter"></i> Android-Libs</a>
        </li>
        <li>
            <a href="http://twitter.com/AlexMahrt" target="_blank"><i class="fa fa-fw fa-twitter"></i> AlexMahrt</a>
        </li>
        <li>
            <a href="https://lk.linkedin.com/in/chathurawijesinghe" target="_blank"><i class="fa fa-fw fa-linkedin"></i> Chathura</a>
        </li>
        <li>
            <a href="https://gratipay.com/cyruxx" target="_blank"><i class="fa fa-fw fa-heart"></i> GratiPay</a>
        </li>
	</ul>
        @if( Sentry::check() )
        <li class="dropdown">
            <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                <img src="{{ Sentry::getUser()->getAvatar() }}">
                <span>{{ Sentry::getUser()->username }} <i class="fa fa-fw fa-caret-down"></i> </span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('/user/profile', [], true) }}"><i class="fa fa-fw fa-user"></i> Profile</a></li>
                <li><a href="{{ url('/user/profile#likes', [], true) }}"><i class="fa fa-fw fa-thumbs-up"></i> Likes</a></li>
                @if( Sentry::getUser()->hasAnyAccess([ 'admin' ]) )
                <li><a href="{{ url('/admin', [], true) }}"><i class="fa fa-fw fa-star dropdown-icon"></i> Administration</a></li>
                @endif
                <li class="divider"></li>
                <li><a href="{{ url('/logout', [], true) }}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
            </ul>
        </li>
        @else
        <li><a href="{{ url('/login', [], true) }}"><i class="fa fa-fw fa-sign-in"></i> Sign in</a></li>
        <li><a href="{{ url('/register', [], true) }}"><i class="fa fa-fw fa-check"></i> Sign up</a></li>
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
    --}}{{--

    <li>
        <form class="navbar-form search-libs-form pull-left">
            <input type="text" class="form-control" placeholder="Search">
        </form>
    </li>
    --}}{{--



    </ul>
    <!-- / .navbar-nav -->
    </div>
    <!-- / .right -->
    </div>
    </div>
    <!-- / #main-navbar-collapse -->
    </div>
    <!-- / .navbar-inner -->
    </div>--}}

    <header>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-3 text-header visible-xs">
                    <div class="row visible-xs">
                        <div class="col-xs-3 dropdown">
                            <button class="btn btn-link navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-ajobs-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div class="col-xs-9 padding-top-6">
                            <h1>
                                <a href="{{ url('/', [], true) }}" class="header-title">
                                    Android<span class="text-bold">Libs</span>
                                </a>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 text-header hidden-xs">
                    <h1>
                        <a href="{{ url('/', [], true) }}" class="header-title">
                            Android<span class="text-bold">Libs</span>
                        </a>
                    </h1>
                    <h2>Your portal for android libraries and tools</h2>
                </div>
                <div class="hidden-xs col-sm-9">
                    <nav>
                        <ul class="list-inline text-right">
                            <li><a href="{{ url('/', [], true) }}">Home</a></li>
                            <li><a href="{{ url('/about', [], true) }}">About</a></li>
                            <li><a href="{{ url('/featured', [], true) }}">Featured</a></li>
                            {{--<li><a href="{{ url('/blog') }}">Blog</a></li>--}}
                            @if(Sentry::check())
                                <li class="dropdown dropdown-nav">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Sentry::getUser()->username }}</a>
                                    <ul class="dropdown-menu text-left">
                                        <li><a href="{{ url('/user/profile', [], true) }}"><i class="fa fa-fw fa-cog"></i> Profile / Settings</a></li>
                                        <li><a href="{{ url('/logout', [], true) }}"><i class="fa fa-fw fa-power-off"></i> Sign out</a></li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{ url('/login', [], true) }}">Sign in</a></li>
                            @endif
                            <li><a href="{{ url('/rss', [], true) }}" target="_blank">RSS</a></li>
                            <li class="dropdown dropdown-nav">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Social</a>
                                <ul class="dropdown-menu text-left">
                                    <li><a href="https://twitter.com/Android_Libs" target="_blank"><i
                                                    class="fa fa-fw fa-twitter"></i> @Android_Libs</a></li>
                                    <li><a href="https://twitter.com/AlexMahrt" target="_blank"><i
                                                    class="fa fa-fw fa-twitter"></i> @AlexMahrt</a></li>
                                    <li><a href="https://lk.linkedin.com/in/chathurawijesinghe" target="_blank"><i
                                                    class="fa fa-fw fa-linkedin"></i> Chathura</a></li>
                                    <li><a href="https://gitter.im/AndroidLibsCom/Android-Libs" target="_blank"><i
                                                    class="fa fa-fw fa-comments"></i> Gitter</a></li>
                                    <li><a href="https://github.com/AndroidLibsCom/Android-Libs" target="_blank"><i
                                                    class="fa fa-fw fa-github"></i> GitHub</a></li>
                                    <li><a href="https://gratipay.com/cyruxx" target="_blank"><i
                                                    class="fa fa-fw fa-heart"></i> Gratipay</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ url('/submit', [], true) }}" class="btn-submit">Submit Library</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="navbar-collapse navbar-ajobs-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/', [], true) }}"><i class="fa fa-fw fa-home"></i> Home</a></li>
                <li><a href="{{ url('/about', [], true) }}"><i class="fa fa-fw fa-info-circle"></i> About</a></li>
                {{--<li><a href="{{ url('/blog') }}">Blog</a></li>--}}
                @if(Sentry::check())
                    <li class="dropdown dropdown-nav">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                                    class="fa fa-fw fa-user"></i> {{ Sentry::getUser()->username }}</a>
                        <ul class="dropdown-menu text-left">
                            <li><a href="{{ url('/user/profile', [], true) }}"><i class="fa fa-fw fa-cog"></i> Profile / Settings</a></li>
                            <li><a href="{{ url('/logout', [], true) }}"><i class="fa fa-fw fa-power-off"></i> Sign out</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ url('/login', [], true) }}"><i class="fa fa-fw fa-sign-in"></i>Sign in</a></li>
                @endif
                <li><a href="{{ url('/rss', [], true) }}" target="_blank"><i class="fa fa-fw fa-rss"></i>RSS</a></li>
                <li class="dropdown dropdown-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                                class="fa fa-fw fa-users"></i> Social</a>
                    <ul class="dropdown-menu text-left">
                        <li><a href="https://twitter.com/Android_Libs" target="_blank"><i
                                        class="fa fa-fw fa-twitter"></i> @Android_Libs</a></li>
                        <li><a href="https://twitter.com/AlexMahrt" target="_blank"><i
                                        class="fa fa-fw fa-twitter"></i> @AlexMahrt</a></li>
                        <li><a href="https://lk.linkedin.com/in/chathurawijesinghe" target="_blank"><i
                                        class="fa fa-fw fa-linkedin"></i> Chathura</a></li>
                        <li><a href="https://gitter.im/AndroidLibsCom/Android-Libs" target="_blank"><i
                                        class="fa fa-fw fa-comments"></i> Gitter</a></li>
                        <li><a href="https://github.com/AndroidLibsCom/Android-Libs" target="_blank"><i
                                        class="fa fa-fw fa-github"></i> GitHub</a></li>
                        <li><a href="https://gratipay.com/cyruxx" target="_blank"><i
                                        class="fa fa-fw fa-heart"></i> Gratipay</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/submit', [], true) }}"><i class="fa fa-fw fa-envelope"></i> Submit Library</a></li>
            </ul>
        </div>
    </header>

    <main>
        @include('alerts')
        @yield('content')
    </main>
    @include('modals.global')
</div>

{{ Assets::js() }}

</body>
</html>
