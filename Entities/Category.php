<?php namespace Modules\Blog\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'slug'];
    protected $fillable = ['name', 'slug', 'on_backend'];
    protected $table = 'blog__categories';

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'blog__post_category');
    }
}
