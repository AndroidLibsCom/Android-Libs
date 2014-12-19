@extends('layout')

@section('content')

{{--Show old search query--}}
@if(Input::old('query', false) !== false)
    <div class="row">
        <div class="col-xs-12">
            <h2>Search results for "{{ Input::old('query', '') }}":</h2>
            <hr>
        </div>
    </div>
@endif

<div class="row">
    <!-- Navigation / Filtering -->
    <div class="col-xs-12 col-md-3">
        <div class="box">
            <span class="box-head">Search</span>
            <div class="box-inner">
                <form method="post" action="{{ url('/search') }}">
                    <input type="text" class="form-control input-search" name="query" placeholder="Search for libraries ...">
                </form>
            </div>
        </div>
        <div class="box">
            <span class="box-head">Categories</span>
            <div class="box-inner">
                <select name="inputCategory" class="inputCategory form-control enable-select2" data-placeholder="Select a category">
                    <option></option>
                    <option value="null">Show all</option>
                    @foreach( $categories as $category)
                    <option value="{{ $category->slug }}" {{ isset($slug) && $slug == $category->slug ? 'selected' : ''  }}>{{ $category->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="box hidden-xs hidden-sm">
            <span class="box-head">Top Categories</span>
            <div class="box-inner">
                <div class="list-group">
                    @if($oTopCategories->count() == 0)
                    <a href="#" class="list-group-item text-center">
                        No libraries found
                    </a>
                    @endif
                    @foreach($oTopCategories as $oTopCat)
                        <a href="{{ url('/search/' . $oTopCat->category->slug) }}" class="list-group-item {{ isset($slug) && $slug == $oTopCat->category->slug ? 'active' : ''  }}">
                            {{ $oTopCat->category->name }}
                            {{--TODO REMOVE HIDDEN--}}
                            <span class="badge badge-default">{{ $oTopCat->likes }} <i class="fa fa-fw fa-thumbs-up"></i></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="box hidden-xs hidden-sm">
            <span class="box-head">5 Random Libs</span>
            <div class="box-inner">
                <div class="list-group">
                    @foreach($oRandomLibs as $oRandomLib)
                        <a href="{{ url('/lib/' . $oRandomLib->slug) }}" class="list-group-item">
                            {{ $oRandomLib->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="box hidden-xs hidden-sm">
            <span class="box-head">Users</span>
            <div class="box-inner">
                <div class="list-group">
                    <a href="#" class="list-group-item">{{ $iUsers }} registered users.</a>
                    <a href="{{ url('/user/' . Sentry::findAllUsers()[$iUsers - 1]->username) }}" class="list-group-item">Last registered: {{ Sentry::findAllUsers()[$iUsers - 1]->username }}</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Rows -->
    <div class="col-xs-12 col-md-9 lib-rows">
        <!-- Library row of 4 -->
        @foreach($libraries as $aLibraries)
        <div class="row lib-row">
            @foreach($aLibraries as $oLibrary)
            <div class="col-xs-12 col-md-4 lib-box">
                <div class="box" data-lib-id="{{ $oLibrary->id }}" data-index="{{ $oLibrary->index }}">
                    <div class="box-inner">
                        <a href="{{ url('/lib/' . $oLibrary->getSlug()) }}">
                            @if($oLibrary->getImages() == null)
                                <img src="{{ asset('/assets/img/lib_placeholder.png') }}">
                            @else
                                <img src="{{ asset('/assets/img/libs/' . $oLibrary->getImages()[0] . '.png') }}">
                            @endif
                            <div class="box-lib-title">
                                @if($oLibrary->featured)
                                <i class="fa fa-fw fa-star text-warning" data-toggle="tooltip" data-title="This library is featured."></i>
                                @endif
                                {{ $oLibrary->title }}
                                <a href="{{ url('/search/' . $oLibrary->categories->slug) }}" class="text-muted text-sm pull-right">
                                    <span class="label label-primary">
                                        {{ $oLibrary->categories->name }}
                                    </span>
                                </a>
                            </div>
                            <div class="box-lib-desc">
                                {{ $oLibrary->getShortenedDescription() }}
                            </div>
                        </a>
                        <div class="stat-counters no-border-t text-center">
                            <!-- Small padding, without horizontal padding -->
                            <div class="stat-cell col-xs-3 padding-sm no-padding-hr hoverable ">
                                <!-- Big text -->
                                <span class="text-sm"><strong class="lib-date">{{ $oLibrary->getCreatedDate() }} </strong></span><br>
                                <!-- Extra small text -->
                                <span class="text-xs"><i class="fa fa-fw fa-calendar-o"></i> ADDED </span>
                            </div>
                            <!-- Small padding, without horizontal padding -->
                            <div class="stat-cell col-xs-3 padding-sm no-padding-hr hoverable ">
                                <!-- Big text -->
                                <span class="text-bg"><strong class="gh-issues"><i class="fa fa-fw fa-refresh"></i> </strong></span><br>
                                <!-- Extra small text -->
                                <span class="text-xs"><i class="fa fa-fw fa-github"></i> ISSUES </span>
                            </div>
                            <!-- Small padding, without horizontal padding -->
                            <div class="stat-cell col-xs-3 padding-sm no-padding-hr hoverable ">
                                <!-- Big text -->
                                <span class="text-bg"><strong class="gh-starred"><i class="fa fa-fw fa-refresh"></i></strong></span><br>
                                <!-- Extra small text -->
                                <span class="text-xs"><i class="fa fa-fw fa-github"></i> STARRED</span>
                            </div>
                            <!-- Small padding, without horizontal padding -->
                            <div class="stat-cell col-xs-3 padding-sm no-padding-hr hoverable ">
                                <!-- Big text -->
                                <span class="text-bg"><strong>{{ $oLibrary->likes->count() }}</strong></span><br>
                                <!-- Extra small text -->
                                <span class="text-xs"><i class="fa fa-fw fa-thumbs-up"></i> LIKES </span>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            @endforeach
        </div>
        @endforeach
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                {{ $oPagination->links() }}
                <br><br><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    init.push(function() {
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top',
            container: 'body'
        });
    });
</script>
@include('modals.index')
@stop