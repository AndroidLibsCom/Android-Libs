@extends('layout')

@section('content')
<div class="container">
    <ul class="nav nav-tabs nav-tabs-simple menu-tabs nav-justified" role="tablist">
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
                            <input type="text" class="form-control" name="keywords" placeholder="SEO Keywords" required>
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
                    	    <textarea class="form-control" name="description" id="addDescription" placeholder="Description" maxlength="1000" rows="10"></textarea>
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

    <div class="modal fade" id="editLibModal">
        <form class="editLibForm" enctype="multipart/form-data" method="post" action="{{ url('/admin/lib/update') }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Library</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId" value="">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="editTitle" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <input type="url" class="form-control" name="url" id="editUrl" placeholder="URL" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="gradle" id="editGradle" placeholder="com.squareup:android-times-square:1.5.0">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="min_sdk" id="editMinSdk" placeholder="Minimum SDK Level" min="1" max="20" step="1">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="keywords" id="editKeywords" placeholder="SEO Keywords" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control select2" name="category" id="editCategory" data-placeholder="Category" required>
                                <option></option>
                                @foreach($oCats as $oCat)
                                    <option value="{{ $oCat->id }}">{{ $oCat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="editDescription" placeholder="Description" maxlength="1000" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="px" name="public" id="editPublic" value="true" checked>
                                <span class="lbl">Public?</span>
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="px" name="featured" id="editFeatured" value="true">
                                <span class="lbl">Featured?</span>
                            </label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="px" name="allowEditImage" id="allowEditImage" value="true">
                                <span class="lbl">Do you want to change the primary image?</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="inputImage">Select an image and crop it below</label>
                            <input type="file" id="inputImage" class="inputImage" accept="image/png" name="inputImage">
                            <input type="hidden" id="inputBaseImage" name="inputBaseImage" value="">
                            <p class="help-block text-danger">If you upload any other sizes we will replace your image with a placeholder!</p>
                        </div>
                        <div class="form-group img-container">
                            <label>Image Preview</label><br>
                            <img src="{{ asset('/assets/img/lib_placeholder.png') }}" alt="Preview Image" class="edit-img-preview">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times"></i></button>
                        <button type="submit" class="btn btn-success submit-btn"><i class="fa fa-fw fa-check"></i></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </form>
    </div><!-- /.modal -->
</div>

<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js)-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/blackboard.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.min.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.min.js"></script>


<script type="text/javascript">
    init.push(function() {

        // Summernote
        if (! $('html').hasClass('ie8')) {
            $('#addDescription').summernote({
                height: 200,
                tabsize: 2,
                codemirror: {
                    theme: 'monokai'
                }
            });
        }




        $('ul.menu-tabs').tabdrop();

        // Open tab by hash
        if(window.location.hash.length > 0)
        {
            $('a[href="' + window.location.hash + '"]').tab('show');
        }

        $('.select2').select2();
        $('.file-input').pixelFileInput();

        $('.public-libs').dataTable({
            'ajax': '{{ url('/admin/public/get') }}',
            'order': [[ 0, 'desc' ]],
            'fnDrawCallback': function (oSettings) {

                // Edit
                $('.btn-edit-lib').off('click');
                $('.btn-edit-lib').click(function (e) {
                    e.preventDefault();
                    var editModal = $('#editLibModal');
                    var editForm  = editModal.find('form');
                    var curBtn    = $(this);
                    editForm.trigger('reset');

                    var image = editForm.find('.edit-img-preview');

                    $.ajax({
                        url: '{{ url('/admin/lib/get') }}',
                        type: 'get',
                        data: {
                            id: curBtn.attr('data-id')
                        },
                        success: function (oLib) {

                            // Update fields
                            editForm.find('#editId').val(oLib.id);
                            editForm.find('#editTitle').val(oLib.title);
                            editForm.find('#editUrl').val(oLib.url);
                            editForm.find('#editGradle').val(oLib.gradle);
                            editForm.find('#editMinSdk').val(oLib.min_sdk);
                            editForm.find('#editKeywords').val(oLib.keywords);
                            editForm.find('#editDescription').val(oLib.description);

                            editForm.find('#editPublic').attr('selected', oLib.public == '1' ? 'true' : 'false');
                            editForm.find('#editFeatured').attr('selected', oLib.featured == '1' ? 'true' : 'false');

                            editForm.find('#editCategory').select2('val', oLib.category_id);

                            var images = JSON.parse(oLib.img);

                            if(images != null) {
                                if (images.length > 0) {
                                    image.attr('src', '{{ asset("assets/img/libs") }}/' + images[0] + '.png');
                                }
                            }

                            // Summernote
                            if (! $('html').hasClass('ie8')) {
                                $('#editDescription').summernote('destroy').summernote({
                                    height: 200,
                                    tabsize: 2,
                                    codemirror: {
                                        theme: 'monokai'
                                    }
                                });
                            }

                            var inputImage      = $("#inputImage");
                            var inputBaseImage  = $('#inputBaseImage');

                            // Image cropper
                            image.cropper({
                                aspectRatio: 16 / 9,
                                data: {
                                    width: 400,
                                    height: 200
                                },
                                resizable: false,
                                dragCrop: false
                            });


                            image.off('built.cropper');
                            image.on('built.cropper', function () {

                                if (window.FileReader) {
                                    inputImage.change(function() {
                                        var fileReader = new FileReader(),
                                                files = this.files,
                                                file;

                                        if (!files.length) {
                                            return;
                                        }

                                        file = files[0];

                                        if (/^image\/\w+$/.test(file.type)) {
                                            fileReader.readAsDataURL(file);
                                            fileReader.onload = function () {
                                                image.cropper("reset", true).cropper("replace", this.result).cropper('enable');
                                                inputImage.val("");
                                            };
                                        } else {
                                            bootbox.alert("Please choose an image file.");
                                        }
                                    });
                                } else {
                                    inputImage.addClass("hidden");
                                }
                            });



                            // Submit form
                            editForm.find('.submit-btn').off('click');
                            editForm.find('.submit-btn').on('click', function (e) {
                                e.preventDefault();
                                inputBaseImage.val(image.cropper('getDataURL'));
                                editForm.submit();
                            });

                            // Show modal
                            editModal.modal('show');
                        },
                        error: function () {
                            bootbox.alert('Something went wrong!');
                        }
                    });

                });
            }
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
        });

    });
</script>
@stop