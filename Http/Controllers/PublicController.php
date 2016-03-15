<?php namespace Modules\Blog\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Setting;

class PublicController extends BasePublicController
{
    use \Modules\Blog\Http\Controllers\BlogPostControllerTrait;
    /**
     * @var PostRepository
     */
    private $post;

    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(PostRepository $post, CategoryRepository $category)
    {
        parent::__construct();
        $this->post = $post;
        $this->category = $category;
    }

    public function index()
    {
        $posts_per_page = Setting::get('blog::posts-per-page', null, 10);
        $posts = $this->getPostQuery()->paginate($posts_per_page);
        $categories = $this->category->allTranslatedIn(App::getLocale());

        return view('blog.index', compact('posts', 'categories'));
    }

    public function category($slug)
    {
        $posts_per_page = Setting::get('blog::posts-per-page', null, 10);
        $categories = $this->category->allTranslatedIn(App::getLocale());
        $category = $this->category->findBySlug($slug);
        $posts = $this->getPostQuery()->whereHas('categories', function(Builder $q) use ($category) {
            $q->where('category_id', $category->id);
        })->paginate($posts_per_page);

        return view('blog.category', compact('posts', 'categories', 'category'));
    }

    public function show($slug)
    {
        $post = $this->getPostQuery($slug)->firstOrFail();
        $categories = $this->category->allTranslatedIn(App::getLocale());

        return view('blog.show', compact('post', 'categories'));
    }
}
