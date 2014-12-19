<?php

class Like extends Eloquent {

    protected $table = 'library_like';
    public $timestamps = false;

    function category()
    {
        return $this->hasOne('Categories', 'id', 'category_id');
    }

    function library()
    {
        return $this->hasOne('Libraries', 'id', 'library_id');
    }

}