{{--<div class="modal fade" id="featureModal">--}}
    {{--{{ Form::open(['url' => '/suggest/feature', 'method' => 'POST']) }}--}}
	{{--<div class="modal-dialog">--}}
		{{--<div class="modal-content">--}}
			{{--<div class="modal-header">--}}
				{{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
				{{--<h4 class="modal-title">Suggest a feature</h4>--}}
			{{--</div>--}}
			{{--<div class="modal-body">--}}
                {{--<p><strong>Looking for a feature?</strong> But you can't find it? Just suggest it in this form; we'll reply to you as soon as possible!</p>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="email">Your E-Mail</label>--}}
                    {{--{{ Form::email('email', Sentry::check() ? Sentry::getUser()->email : null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'email@example.com']) }}--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="suggestion">Your Feature Suggestion</label>--}}
                    {{--{{ Form::textarea('suggestion', null, ['class' => 'form-control', 'id' => 'suggestion', 'placeholder' => 'Describe the feature as best as you can!', 'rows' => '10']) }}--}}
                {{--</div>--}}
            {{--</div>--}}
			{{--<div class="modal-footer">--}}
				{{--<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times"></i></button>--}}
				{{--<button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i></button>--}}
			{{--</div>--}}
		{{--</div><!-- /.modal-content -->--}}
	{{--</div><!-- /.modal-dialog -->--}}
    {{--{{ Form::close() }}--}}
{{--</div><!-- /.modal -->--}}