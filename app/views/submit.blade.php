@extends('layout')

@section('content')
<form role="form" class="add-lib-form" enctype="multipart/form-data" method="post" action="submit">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="inputTitle">Library name</label>
                <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Toast Library" required>
            </div>
            <div class="form-group">
                <label for="inputUrl">URL to Library</label>
                <input type="url" class="form-control" name="inputUrl" id="inputUrl" placeholder="http://github.com/example" required>
                <p class="help-block">We can fetch data, like open issues, from GitHub, if you provide a valid GitHub URL.</p>
            </div>
            <div class="form-group">
                <label for="inputUrl">Gradle</label>
                <input type="text" class="form-control" name="inputGradle" id="inputGradle" placeholder="com.squareup:android-times-square:1.5.0">
                <p class="help-block">Provide without the compile '' part.</p>
            </div>
            <div class="form-group">
                <label for="inputMinSdk">Minimum SDK Level</label>
                <input type="number" min="1" max="20" step="1" class="form-control" name="inputMinSdk" id="inputMinSdk" placeholder="12">
                <p class="help-block">Please provide the minimum SDK level required to use your library.</p>
            </div>
            <div class="form-group">
                <label class="checkbox-inline">
                    <input type="checkbox" class="px" name="allowImage" id="allowImage" value="true">
                    <span class="lbl">Do you want to upload a image?</span>
                </label>
            </div>
            <div class="form-group">
                <label for="inputImage">Select an image and crop it below</label>
                <input type="file" id="inputImage" class="inputImage" accept="image/png" name="inputImage">
                <input type="hidden" id="inputBaseImage" name="inputBaseImage" value="">
            </div>
            <div class="form-group img-container">
                <label>Image Preview</label><br>
                <img src="{{ asset('/assets/img/submit_preview.png') }}" alt="Preview Image" class="add-prev-img">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="inputCategory">Category</label>
                <select name="inputCategory" class="form-control select2" data-placeholder="Please select a category" id="inputCategory" required>
                    <option></option>
                    @foreach($oCategories as $oCat)
                    <option value="{{ $oCat->id }}">{{ $oCat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="inputSubmitterEmail">Your E-Mail</label>
                @if(Sentry::check())
                <input type="email" class="form-control disabled"  value="{{ Sentry::getUser()->email }}" placeholder="foo@bar.com" required disabled>
                <input type="hidden" name="inputSubmitterEmail"  value="{{ Sentry::getUser()->email }}">
                <p class="help-block">We will use your user account's email address.</p>
                @else
                <input type="email" class="form-control" name="inputSubmitterEmail" id="inputSubmitterEmail" placeholder="foo@bar.com" required>
                <p class="help-block">We will send status-notifications about your submission. <strong>Nothing else!</strong></p>
                @endif
            </div>
            <div class="form-group">
                <label for="inputDesc">Description</label><br>
                <label class="checkbox-inline">
                    <input type="checkbox" name="fetchDesc" class="px" id="fetchDesc" value="true">
                    <span class="lbl">Fetch description from GitHub</span>
                </label>
                <br><br>
                <textarea class="form-control max-length-input" name="inputDesc" id="inputDesc" maxlength="1000" rows="10" placeholder="Describe the library as best as you can." required></textarea>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
    	<div class="hidden-xs col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary btn-lg btn-flat btn-labeled">
                <span class="btn-label icon fa fa-send"></span> Submit library
            </button>
    	</div>
    	<div class="visible-xs col-xs-12">
            <button type="submit" class="btn btn-block btn-primary btn-lg btn-flat btn-labeled">
                <span class="btn-label icon fa fa-send"></span> Submit library
            </button>
    	</div>
    </div>
</form>
<script>
    init.push(function() {
        //$('input[type="file"]').pixelFileInput();
        $('.select2').select2();
        var image = $('.add-prev-img');
        image.cropper({
            aspectRatio: 16 / 9,
            data: {
                width: 400,
                height: 200
            },
            resizable: false,
            dragCrop: false
        });

        var inputImage      = $("#inputImage");
        var inputBaseImage  = $('#inputBaseImage');

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
                image.cropper("reset", true).cropper("replace", this.result);
                inputImage.val("");
              };
            } else {
              bootbox.alert("Please choose an image file.");
            }
          });
        } else {
          inputImage.addClass("hidden");
        }

        $('.add-lib-form button[type="submit"]').click(function(e) {
            e.preventDefault();
            inputBaseImage.val(image.cropper('getDataURL'));
            $('.add-lib-form').submit();
        });


        var inputDesc = $('#inputDesc');
        // Disable / Enable description
        $('#fetchDesc').change(function(e) {
            if($(this).is(':checked'))
            {
                inputDesc.attr('disabled', 'disabled');
            }
            else
            {
                inputDesc.removeAttr('disabled');
            }
        });

    });
</script>
@stop