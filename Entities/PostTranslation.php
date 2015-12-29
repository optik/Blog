<?php namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'content', 'meta_title', 'meta_keywords', 'meta_description'];
    protected $table = 'blog__post_translations';
}
