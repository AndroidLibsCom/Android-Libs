@extends('layout')

@section('content')
<div class="container">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#public-libs" role="tab" data-toggle="tab"><i class="fa fa-fw fa-globe"></i> Public libraries</a></li>
        <li><a href="#submitted-libs" role="tab" data-toggle="tab"><i class="fa fa-fw fa-send-o"></i> Submitted libraries</a></li>
        <li><a href="#add" role="tab" data-toggle="tab"><i class="fa fa-fw fa-plus"></i> Add library</a></li>
    </ul>
    <br>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="public-libs">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover table-bordered table-with-actions public-libs">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>E-Mail</th>
                            <th>URL Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{--Ajax Loaded content--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="submitted-libs">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover table-bordered table-with-actions submitted-libs">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>E-Mail</th>
                            <th>Description</th>
                            <th>URL Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{--Ajax Loaded content--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="add">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('/admin/add') }}" method="POST" enctype="multipart/form-data" role="form" >
                    	<legend>Add a library</legend>

                    	<div class="form-group">
                    	    <input type="text" class="form-control" name="title" placeholder="Title" required>
                    	</div>
                    	<div class="form-group">
                    	    <input type="url" class="form-control" name="url" placeholder="URL" required>
                    	</div>
                    	<div class="form-group">
                    	    <input type="text" class="form-control" name="gradle" placeholder="com.squareup:android-times-square:1.5.0">
                    	</div>
                    	<div class="form-group">
                    	    <input type="number" class="form-control" name="min_sdk" placeholder="Minimum SDK Level" min="1" max="20" step="1">
                    	</div>
                    	<div class="form-group">
                    	    <select class="form-control select2" name="category" data-placeholder="Category" required>
                    	        <option></option>
                    	        @foreach($oCats as $oCat)
                    	            <option value="{{ $oCat->id }}">{{ $oCat->name }}</option>
                    	        @endforeach
                    	    </select>
                    	</div>
                    	<div class="form-group">
                    	    <input type="file" class="file-input" name="img" placeholder="Image" data-placeholder="Image">
                    	</div>
                    	<div class="form-group">
                    	    <textarea class="form-control" name="description" placeholder="Description" maxlength="1000" rows="10" required></textarea>
                    	</div>

                    	<div class="form-group">
                    	    <label class="checkbox-inline">
                                <input type="checkbox" class="px" name="public" value="true" checked>
                                <span class="lbl">Public?</span>
                            </label>
                    	</div>

                    	<div class="form-group">
                    	    <label class="checkbox-inline">
                                <input type="checkbox" class="px" name="featured" value="true">
                                <span class="lbl">Featured?</span>
                            </label>
                    	</div>

                    	<hr>
                    	<div class="text-right">
                    	    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Add</button>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
    init.push(function() {

        // Open tab by hash
        if(window.location.hash.length > 0)
        {
            $('a[href="' + window.location.hash + '"]').tab('show');
        }

        $('.select2').select2();
        $('.file-input').pixelFileInput();

        $('.public-libs').dataTable({
            'ajax': '{{ url('/admin/public/get') }}'
        });

        $.ajax({
            url: '{{ url('/admin/submitted/get') }}',
            type: 'get',
            success: function(data) {
                $('.submitted-libs').dataTable({
                    data: data.data
                });

                $('.btn-accept').click(function(e) {
                   e.preventDefault();
                   var btn = $(this);
                   bootbox.confirm('Do you want to accept this library?', function() {
                        window.location.href = '{{ url('/admin/lib/accept') }}/' + btn.attr('data-id');
                   });
                });

                $('.btn-decline').click(function(e) {
                   e.preventDefault();
                   var btn = $(this);
                   bootbox.prompt('Why do you want to decline that library?', function(reason) {
                        if(reason !== null)
                        {
                            window.location.href = '{{ url('/admin/lib/decline') }}/' + btn.attr('data-id') + '/' + reason;
                        }
                   });
                });
            }
        })
    });
</script>
@stop