{{--Suggest image / page 'show'--}}

<div id="suggestImageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ url('/lib/image/suggest') }}" enctype="multipart/form-data" class="suggest-image-form">
                <input type="hidden" name="id" value="{{ $oLib->id }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="suggestImageModalLabel">Suggest a image for "{{ $oLib->title }}"</h4>
                </div>
                <div class="modal-body">
                    <p class="row-margin-bottom">Please <strong>do not</strong> submit any unrelated images. Thank you!</p>
                        <div class="form-group">
                            <label for="url" class="control-label">Link to image</label>
                            <input type="url" class="form-control suggest-image-url-input" id="url" name="url" placeholder="https://android-libs.com/cool-library.png" required>
                            <p class="help-block" style="display: none;">
                                You can not fill both fields.
                            </p>
                        </div>


                        <div class="row row-margin-bottom">
                            <div class="col-xs-12 text-center text-bg">OR</div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <img src="https://placehold.it/400x200?text=Placeholder" class="img-responsive suggest-image-preview box">
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group">
                                    <label for="file" class="control-label">Image (*.png only)</label>
                                    <input type="file" accept="image/png" class="suggest-image-input" name="image" required>
                                    <p class="help-block" style="display: none;">
                                        You can not fill both fields.
                                    </p>
                                </div>
                            </div>
                        </div>
                </div> <!-- / .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-suggest-image">Submit</button>
                </div>
            </form>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div class="modal fade" id="shieldGenerator">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Generate Shield</h4>
			</div>
			<div class="modal-body">
                <div class="form-group">
                    <label for="color">Color</label>
                    <select class="form-control" id="color">
                        <option value="blue">Blue</option>
                        <option value="red">Red</option>
                        <option value="green">Green</option>
                        <option value="brightgreen" selected>Bright Green</option>
                        <option value="yellowgreen">Yellow Green</option>
                        <option value="lightgrey">Light Grey</option
                        <option value="red">Red</option>
                        <option value="yellow">Yellow</option>
                        <option value="orange">Orange</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" class="px" name="flat" id="not_flat" value="not_flat">
                        <span class="lbl">Not Flat</span>
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" class="px" name="flat" id="flat" checked value="flat">
                        <span class="lbl">Flat</span>
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" class="px" name="flat" id="flatSquared" value="flat-square">
                        <span class="lbl">Flat Squared</span>
                    </label>
                </div>
                <hr>
                <div class="form-group">
                    <label>Preview</label><br>
                    <img src="https://img.shields.io/badge/AndroidLibs-{{ str_replace('-', '%20', htmlentities($oLib->title)) }}-brightgreen.svg?style=flat" alt="{{ $oLib->title }}" id="prev_img">
                </div>
                <div class="form-group">
                    <label>Markdown</label>
                    <textarea class="form-control" rows="4" id="prev_markdown" readonly aria-readonly="true">[![AndroidLibs](https://img.shields.io/badge/AndroidLibs-{{ htmlentities(str_replace('-', '%20',$oLib->title)) }}-brightgreen.svg?style=flat)]({{ url('/lib/' . $oLib->slug . '?utm_source=github-badge&utm_medium=github-badge&utm_campaign=github-badge', [], true) }})</textarea>
                    <p class="help-block">Click to select markdown. CTRL+C to copy; CTRL+V to paste.</p>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-fw fa-check"></i></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    init.push(function() {
        function htmlEntities(str) {
            return String(str).replace(/ /g, '%20').replace('-', '%20');
        }
        var lTitle    = '{{ $oLib->title }}';
        var lUrl      = '{{ url('/lib/' . $oLib->slug . '?utm_source=github-badge&utm_medium=github-badge&utm_campaign=github-badge', [], true) }}}';
        var shColor   = $('#color');
        var shNotFlat = $('#not_flat');
        var shFlat    = $('#flat');
        var shFlatSq  = $('#flatSquared');
        var mdPrev    = $('#prev_markdown');
        var imgPrev   = $('#prev_img');

        shColor.change(function() {
            var flatStr = '';
            if(shFlat.is(':checked'))
            {
                flatStr = '?style=flat';
            }
            if(shFlatSq.is(':checked'))
            {
                flatStr = '?style=flat-square';
            }
            if(shNotFlat.is(':checked'))
            {
                flatStr = '';
            }

            // Change markdown preview
            mdPrev.text('[![AndroidLibs](https://img.shields.io/badge/AndroidLibs-'
                + htmlEntities(lTitle) + '-' + shColor.find('option:selected').val() + '.svg' + flatStr + ')]({{ url('/lib/' . $oLib->slug . '?utm_source=github-badge&utm_medium=github-badge&utm_campaign=github-badge', [], true) }})');

            // Change image preview
            imgPrev.attr('src', 'https://img.shields.io/badge/AndroidLibs-'
                + htmlEntities(lTitle) + '-' + shColor.find('option:selected').val() + '.svg' + flatStr);
        });

        $('[name="flat"]').change(function() {
            var flatStr = '';
            if(shFlat.is(':checked'))
            {
                flatStr = '?style=flat';
            }
            if(shFlatSq.is(':checked'))
            {
                flatStr = '?style=flat-square';
            }
            if(shNotFlat.is(':checked'))
            {
                flatStr = '';
            }
            // Change markdown preview
            mdPrev.text('[![AndroidLibs](https://img.shields.io/badge/AndroidLibs-'
                + htmlEntities(lTitle) + '-' + shColor.find('option:selected').val() + '.svg' + flatStr + ')]({{ url('/lib/' . $oLib->slug . '?utm_source=github-badge&utm_medium=github-badge&utm_campaign=github-badge', [], true) }})');

            // Change image preview
            imgPrev.attr('src', 'https://img.shields.io/badge/AndroidLibs-'
                + htmlEntities(lTitle) + '-' + shColor.find('option:selected').val() + '.svg' + flatStr);
        });


        // Select contents
        mdPrev.on('click', function () {
            $(this).select();
        })
    });
</script>