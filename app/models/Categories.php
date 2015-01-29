<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;


    class Categories extends Eloquent implements SluggableInterface {
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];


    protected $table = 'categories';
    public $timestamps = true;
}