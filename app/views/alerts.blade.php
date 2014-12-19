@if(Session::has('success'))
<?php $titles = [ 'Cool!', 'Great!', 'Yeah!', 'Awesome!' ]; ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4><i class="fa fa-fw fa-check"></i> {{ $titles[array_rand($titles)] }}</h4>
            <p>{{ Session::get('message') }}</p>
        </div>
    </div>
</div>

@endif
@if(Session::has('error'))
<?php $titles = [ 'Oh no!', 'Oops!', 'Dang!', 'Oh oh!' ]; ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4><i class="fa fa-fw fa-times-circle"></i> {{ $titles[array_rand($titles)] }}</h4>
            <p>{{ Session::get('message') }}</p>
        </div>
    </div>
</div>
@endif