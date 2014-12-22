@extends('layout')

@section('body')
<body class="theme-clean no-main-menu page-profile">
@stop

@section('content')
<!-- 5. $PROFILE ===================================================================================

		Profile
-->
    <div class="profile-full-name">
        <span class="text-semibold">{{ $oUser->username }}</span>'s profile
    </div>
    <div class="profile-row">
        <div class="left-col">
            <div class="profile-block">
                <div class="panel profile-photo">
                    <img src="{{ $oUser->getAvatar() }}" alt="{{ $oUser->username }}">
                </div><br>
{{--                <a href="#" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;&nbsp;Following</a>&nbsp;&nbsp;
                <a href="#" class="btn"><i class="fa fa-comment"></i></a>--}}
            </div>

            <div class="panel panel-transparent">
                <div class="panel-heading">
                    <span class="panel-title">Statistics</span>
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item"><strong>{{ $iLikes }}</strong> Likes</a>
                    <a href="#" class="list-group-item"><strong>{{ $oUser->last_login }}</strong> last seen</a>
                    <a href="#" class="list-group-item"><strong>{{ $oSubmittedLibs->count() }}</strong> submitted libraries</a>
                </div>
            </div>

        </div>
        <div class="right-col">

            <hr class="profile-content-hr no-grid-gutter-h">

            <div class="profile-content">

                <ul id="profile-tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#profile-tabs-likes" data-toggle="tab"><i class="fa fa-fw fa-thumbs-up"></i> Likes</a>
                    </li>
                    <li>
                        <a href="#profile-tabs-settings" data-toggle="tab"><i class="fa fa-fw fa-cog"></i> Settings</a>
                    </li>
                </ul>

                <div class="tab-content tab-content-bordered panel-padding">

                    <div class="tab-pane fade in active" id="profile-tabs-likes">
                        <!-- Library row of 3 -->
                            @if(count($oaLikes) == 0)
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    You don't have any likes yet!
                                    <br><br>
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg btn-flat"><i class="fa fa-fw fa-caret-right"></i> Go like something</a>
                                </div>
                            </div>
                            @endif
                            @foreach($oaLikes as $oLikes)
                            <div class="row lib-row">
                                @foreach($oLikes as $oLike)
                                <div class="col-xs-12 col-md-4 lib-box">
                                    <div class="box" data-lib-id="{{ $oLike->library->id }}">
                                        <div class="box-inner">
                                            <a href="{{ url('/lib/' . $oLike->library->getSlug()) }}">
                                                @if($oLike->library->getImages() == null)
                                                    <img src="{{ asset('/assets/img/lib_placeholder.png') }}">
                                                @else
                                                    <img src="{{ asset('/assets/img/libs/' . $oLike->library->getImages()[0] . '.png') }}">
                                                @endif
                                                <div class="box-lib-title">
                                                    {{ $oLike->library->title }}
                                                    <a href="{{ url('/search/' . $oLike->library->categories->slug) }}" class="text-muted text-sm pull-right">
                                                        <span class="label label-primary">
                                                            {{ $oLike->library->categories->name }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="box-lib-desc">
                                                    {{ $oLike->library->getShortenedDescription() }}
                                                </div>
                                            </a>
                                        </div>
                                   </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                    </div> <!-- / .tab-pane -->
                    <div class="tab-pane fade" id="profile-tabs-settings">
                        <form action="{{ url('/user/profile/update') }}" method="POST" role="form" id="profile-settings-form" enctype="multipart/form-data">
                        	<legend>Update your profile settings</legend>

                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="file" class="form-control" name="avatar" id="avatar" accept="image/png">
                                <span class="help-block">We only accept .PNG files.</span>
                            </div>

                        	<div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="remove_avatar" class="px" id="remove_avatar" value="true">
                                    <span class="lbl text-danger">Remove my avatar</span>
                                </label>
                        	</div>

                        	<div class="form-group">
                        		<label for="email">E-Mail</label>
                        		<input type="email" class="form-control" name="email" id="email" placeholder="john.doe@example.com" value="{{ $oUser->email }}">
                        	</div>

                        	<div class="form-group">
                        	    <div class="row">
                        	    	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        	    	</div>
                        	    	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="password_repeat">Repeat password</label>
                                        <input type="password" class="form-control" name="password_repeat" id="password_repeat" placeholder="Repeat password">
                        	    	</div>
                        	    </div>
                        	</div>

                        	<div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="newsletter" class="px" id="newsletter" value="true" {{ $oUser->newsletter ? 'checked' : '' }}>
                                    <span class="lbl">Send me E-Mails from Android-Libs.com</span>
                                </label>
                        	</div>


                            <hr>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary btn-labeled">
                                    <span class="btn-label icon fa fa-save"></span> Save
                                </button>
                            </div>
                        </form>
                    </div> <!-- / .tab-pane -->
                </div> <!-- / .tab-content -->
            </div>
        </div>
    </div>

<script>
init.push(function() {
    $('input[type="file"]').pixelFileInput();

    $('#profile-settings-form').validate({
        rules: {
            'email': {
                required: true,
                email: true
            },
            'password': {
                equalTo: '#password_repeat'
            }
        }
    });
});
</script>



@stop