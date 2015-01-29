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
                </ul>

                <div class="tab-content tab-content-bordered panel-padding">

                    <div class="tab-pane fade in active" id="profile-tabs-likes">
                        <!-- Library row of 3 -->
                            @if(count($oaLikes) == 0)
                            <div class="row">
                            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            		This user does not have any likes yet!
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
                </div> <!-- / .tab-content -->
            </div>
        </div>
    </div>

<script>
init.push(function() {

});
</script>



@stop