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
                            <input type="url" class="form-control suggest-image-url-input" id="url" name="url" placeholder="http://android-libs.com/cool-library.png" required>
                            <p class="help-block" style="display: none;">
                                You can not fill both fields.
                            </p>
                        </div>


                        <div class="row row-margin-bottom">
                            <div class="col-xs-12 text-center text-bg">OR</div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <img src="http://placehold.it/400x200?text=Placeholder" class="img-responsive suggest-image-preview box">
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