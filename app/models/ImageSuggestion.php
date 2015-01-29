<?php

class ImageSuggestion extends Eloquent {

    protected $table = 'image_suggestions';
    public $timestamps = false;

    function library()
    {
        return $this->hasOne('Libraries', 'id', 'library_id');
    }

}