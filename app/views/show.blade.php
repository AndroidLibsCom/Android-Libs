@extends('layout')

@section('content')

<div class="page-header">
    <div class="row">
        <!-- Page header, center on small screens -->
        <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
            @if($oLib->featured)
            <i class="fa fa-fw fa-star text-warning" data-toggle="tooltip" data-title="This library is featured."></i>
            @endif
            {{ $oLib->title }} / <span class="text-light-gray">{{ $oLib->categories->name }}</span>
        </h1>

        <div class="col-xs-12 col-sm-8">
            <div class="row hidden-xs">
                <hr class="visible-xs no-grid-gutter-h">
                <!-- "Create project" button, width=auto on desktops -->
                <div class="pull-right col-xs-12 col-sm-auto">

                    @if($oLib->githubOk)
                    <a href="{{ $oLib->url }}" class="btn btn-default btn-labeled" target="_blank">
                        <span class="btn-label icon fa fa-github"></span> To GitHub website
                    </a>
                    @else
                    <a href="{{ $oLib->url }}" class="btn btn-default btn-labeled" target="_blank">
                        <span class="btn-label icon fa fa-globe"></span> To libraries website
                    </a>
                    @endif

                    {{--<a href="{{ Sentry::check() ? '#' : url('/login') }}" class="btn btn-primary btn-labeled btn-like"--}}
                    @if(Sentry::check())
                        @if($bIsLiked)
                        <a href="#" class="btn btn-primary btn-labeled btn-like" data-liked="false" data-id="{{ $oLib->id }}" data-loading-text="...">
                            <span class="btn-label icon fa fa-thumbs-down"></span> Remove Like
                        </a>
                        @else
                        <a href="#" class="btn btn-primary btn-labeled btn-like" data-liked="true" data-id="{{ $oLib->id }}" data-loading-text="...">
                            <span class="btn-label icon fa fa-thumbs-up"></span> Like
                        </a>
                        @endif
                    @else
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-labeled">
                        <span class="btn-label icon fa fa-thumbs-up"></span> Like
                    </a>
                    @endif
                    <a href="#" class="btn btn-facebook facebook sharrre btn-labeled" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="facebook">
                        <span class="btn-label icon fa fa-facebook"></span> Facebook
                    </a>
                    <a href="#" class="btn btn-info sharrre twitter btn-labeled" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="twitter">
                        <span class="btn-label icon fa fa-twitter"></span> Twitter
                    </a>
                    <a href="#" class="btn btn-danger sharrre gplus btn-labeled" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="gplus">
                        <span class="btn-label icon fa fa-google-plus"></span> Google+
                    </a>
                </div>
            </div>
            {{--SMARTPHONE BUTTONS--}}
            <div class="row visible-xs">
                <div class="col-xs-12">
                    <hr>
                    <div class="row margin-bottom-10">
                        <div class="col-xs-12">
                            @if($oLib->githubOk)
                            <a href="{{ $oLib->url }}" class="btn btn-primary btn-block btn-labeled" target="_blank">
                                <span class="btn-label icon fa fa-github"></span> To GitHub website
                            </a>
                            @else
                            <a href="{{ $oLib->url }}" class="btn btn-primary btn-block btn-labeled" target="_blank">
                                <span class="btn-label icon fa fa-globe"></span> To libraries website
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-xs-12">
                            @if(Sentry::check())
                                @if($bIsLiked)
                                <a href="#" class="btn btn-default btn-labeled btn-block btn-like" data-liked="false" data-id="{{ $oLib->id }}" data-loading-text="...">
                                    <span class="btn-label icon fa fa-thumbs-down"></span> Remove Like
                                </a>
                                @else
                                <a href="#" class="btn btn-default btn-labeled btn-block btn-like" data-liked="true" data-id="{{ $oLib->id }}" data-loading-text="...">
                                    <span class="btn-label icon fa fa-thumbs-up"></span> Like
                                </a>
                                @endif
                            @else
                                <a href="{{ url('/login') }}" class="btn btn-default btn-labeled btn-block">
                                    <span class="btn-label icon fa fa-thumbs-up"></span> Like
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-xs-12">
                    	    <div class="btn-group max-width">
                                <button type="button" class="btn btn-default btn-labeled btn-block" data-toggle="dropdown" aria-expanded="false">
                                    <span class="btn-label icon fa fa-share-alt"></span> Share <i class="fa fa-fw fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu max-width" role="menu">
                                    <li>
                                        <a href="#" class="sharrre facebook" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="facebook">
                                            <i class="fa fa-fw fa-facebook"></i> Facebook
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="sharrre twitter" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="twitter">
                                            <i class="fa fa-fw fa-twitter"></i> Twitter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="sharrre gplus" data-text="I've found this awesome library on Android-Libs! @Android_Libs" data-url="{{ url('/lib/' . $oLib->slug) }}" data-share="gplus">
                                            <i class="fa fa-fw fa-google-plus"></i> Google+
                                        </a>
                                    </li>
                                </ul>
                    	    </div>
                    	</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><i class="panel-title-icon fa fa-image"></i> Images</span>
                        <button type="button" data-toggle="modal" data-target="#suggestImageModal" class="btn btn-primary btn-xs pull-right btn-labeled">
                            <span class="btn-label icon fa fa-bullhorn"></span> Suggest Image
                        </button>
                    </div> <!-- / .panel-heading -->
                    <div class="panel-body padding-sm">
                        @if($oLib->getImages() == null)
                            <div class="text-center text-muted">
                                We could not find any images for this library.
                            </div>
                        @else
                            @foreach($oLib->getImages() as $sImage)
                                <a href="{{ asset('/assets/img/libs/' . $sImage . '.png') }}" data-lightbox="{{ str_random() }}" data-title="{{ $oLib->title }}"><img src="{{ asset('/assets/img/libs/' . $sImage . '.png') }}" class="img-responsive"></a>
                            @endforeach
                        @endif
                    </div> <!-- / .panel-body -->
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><i class="panel-title-icon fa fa-file-text-o"></i> Description</span>
                    </div> <!-- / .panel-heading -->
                    <div class="panel-body padding-sm panel-description">
                        {{ $oLib->description }}
                    </div> <!-- / .panel-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="panel-title-icon fa fa-info"></i>Details</span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body padding-sm">
                <table class="table">
                    <tr>
                        <th class="no-border-t"><i class="fa fa-fw fa-calendar"></i> Added at:</th>
                        <td class="no-border-t">{{ $oLib->getCreatedDate() }}</td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-fw fa-user"></i> Submitted by:</th>
                        @if($oSubmittor != null)
                        <td>
                            <a href="{{ url('/user/' . $oSubmittor->username) }}" class="submittor"
                            data-content="<img src='{{ $oSubmittor->getAvatar() }}' alt='{{ $oSubmittor->username }}' class='img-responsive'>">{{ $oSubmittor->username }}</a>
                        </td>
                        @else
                        <td>
                            Anonymous
                        </td>
                        @endif
                    </tr>
                    <tr>
                        <th><i class="fa fa-fw fa-level-up"></i> Minimum SDK Level:</th>
                        <td>{{ $oLib->getApiLevel() }}</td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-fw fa-tag"></i> Category:</th>
                        <td>{{ $oLib->categories->name }}</td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-fw fa-thumbs-up"></i> Likes:</th>
                        <td>{{ $oLib->likes->count() }}</td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-fw fa-check"></i> See also:</th>
                        <td>
                            @foreach($oFiveRandomLibs as $oRandLib)
                                <a href="{{ url('/lib/' . $oRandLib->slug) }}">{{ $oRandLib->title }}</a><br>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div> <!-- / .panel-body -->
            @if(!$oLib->githubOk)
                <div class="panel-footer btn-footer">
                    <a href="{{ $oLib->url }}" target="_blank" class="btn btn-block btn-primary btn-full"><i class="fa fa-fw fa-globe"></i> Website</a>
                </div>
            @endif
        </div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="fa panel-title-icon fa-android"></i> Gradle</span>
            </div>
            <div class="panel-body">
                @if($oLib->hasGradle())
                <div class="input-group">
                    <input type="text" class="form-control input-gradle" value="compile '{{ $oLib->gradle }}'" readonly>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default btn-gradle"
                            data-toggle="tooltip" data-title="Click to select inputs content"><i class="fa fa-fw fa-clipboard"></i></button>
                    </div>
                </div>
                @else
                <p class="text-center">We do not have any information about gradle support.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="panel-title-icon fa fa-github-square"></i> GitHub Details</span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body padding-sm">
                @if($oLib->githubOk)
                    <table class="table">

                            @if($oLib->githubOk)
                            <tr>
                                <th class="no-border-t"><i class="fa fa-fw fa-user"></i> Owner:</th>
                                <td class="no-border-t">
                                    <a href="{{ $oGitHub->owner->html_url }}" target="_blank">
                                        {{ $oGitHub->owner->login }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-fw fa-star"></i> Starred:</th>
                                <td>{{ $oGitHub->stargazers_count }}</td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-fw fa-eye"></i> Watchers:</th>
                                <td>{{ $oGitHub->subscribers_count }}</td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-fw fa-code-fork"></i> Forks:</th>
                                <td>{{ $oGitHub->forks_count }}</td>
                            </tr>
                            <tr>
                                <th><i class="fa fa-fw fa-exclamation-circle"></i> Open Issues:</th>
                                <td>{{ $oGitHub->open_issues }}</td>
                            </tr>
                        @else
                            <tr>
                                <th class="no-border-t"><i class="fa fa-fw fa-user"></i> Owner:</th>
                                <td class="no-border-t">
                                    {{ $oLib->getGitHubUserName() }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center text-muted" colspan="2">Could not get more information from GitHub.</td>
                            </tr>
                        @endif
                    </table>
                @else
                    <div class="text-center text-muted">
                        This Library has no GitHub URL yet.
                    </div>
                @endif
            </div> <!-- / .panel-body -->
            @if($oLib->githubOk)
                <div class="panel-footer btn-footer">
                    <a href="{{ $oLib->url }}" target="_blank" class="btn btn-block btn-primary btn-full"><i class="fa fa-fw fa-github"></i> GitHub Site</a>
                </div>
            @endif
        </div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="panel-title-icon fa fa-github-square"></i> GitHub Contributors</span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body padding-sm">
                @if($oLib->githubOk)
                    @foreach($aContributors as $aContributor)
                    <a href="{{ $aContributor['html_url'] }}" target="_blank" data-toggle="tooltip" class="thumbnail contr-thumb" data-title="{{ $aContributor['login'] . ' (' . $aContributor['contributions'] . ' commits)' }}">
                        <img src="{{ $aContributor['avatar_url'] }}" alt="{{ $aContributor['login'] }}">
                    </a>
                    @endforeach
                @else
                    <div class="text-center text-muted">
                        This Library has no GitHub URL yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="panel-title-icon fa fa-comments"></i> Comments</span>
            </div> <!-- / .panel-heading -->
            <div class="panel-body padding-sm">
                 <div id="disqus_thread"></div>
                    <script type="text/javascript">
                        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                        var disqus_shortname  = 'android-libs'; // required: replace example with your forum shortname
                        var disqus_identifier = '{{ $oLib->disqus }}';
                        var disqus_url = '{{ url('/lib/' . $oLib->slug ) }}';

                        /* * * DON'T EDIT BELOW THIS LINE * * */
                        (function() {
                            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
            </div> <!-- / .panel-body -->
        </div>
    </div>
</div>

<script>
    init.push(function() {
        var SELECT_TIMEOUT = null;
        var inputGradle = $('.input-gradle');
        $('.btn-gradle').click(function(e) {
            e.preventDefault();
            inputGradle.tooltip('destroy').tooltip({
                placement: 'top',
                trigger: 'manual',
                title: 'Now press CTRL + C to copy to clipboard'
            }).tooltip('show');
            inputGradle.select();

            window.clearTimeout(SELECT_TIMEOUT);
            SELECT_TIMEOUT = window.setTimeout(function() {
                inputGradle.tooltip('hide');
            }, 5000);
        });

        $('.submittor').popover({
            placement: 'auto',
            html: true,
            trigger: 'hover focus'
        });
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
        $('.btn-like').click(function(e) {
            e.preventDefault();
            var btn     = $(this);

            $.ajax({
                url: '{{ url('/lib/like') }}',
                type: 'post',
                data: {
                    id: btn.attr('data-id')
                },
                beforeSend: function() {
                    btn.button('loading');
                },
                success: function(data) {
                    btn.button('reset');
                    if(data.liked)
                    {
                        btn.html('<span class="btn-label icon fa fa-thumbs-down"></span> Remove Like');
                    }
                    else
                    {
                        btn.html('<span class="btn-label icon fa fa-thumbs-up"></span> Like');
                    }
                },
                error: function() {
                    btn.button('reset');
                    bootbox.alert('Something went wrong. Please try again later.');
                }
            });
        });
    });
</script>
@include('modals.show')
@stop