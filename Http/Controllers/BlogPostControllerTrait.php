<?php namespace Modules\Blog\Http\Controllers;

use Modules\Blog\Entities\Post;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Entities\Status;
use Illuminate\Support\Facades\App;

trait BlogPostControllerTrait {

    protected function getPostQuery($slug = null) {
        $lang = App::getLocale();
        return Post::whereHas('translations', function (Builder $q) use ($lang, $slug) {
            $q->where('locale', "$lang");
            $q->where('title', '!=', '');
            if($slug) {
                $q->where('slug', $slug);
            }
        })
            ->with('translations')
            ->with('files')
            ->whereStatus(Status::PUBLISHED)
            ->orderBy('created_at', 'DESC');
    }
}
