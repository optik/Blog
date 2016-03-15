<?php namespace Modules\Blog\Widgets;

use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Entities\Post;
use Modules\Core\Contracts\Setting;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;


class SystemPostsWidget extends BaseWidget
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

    public function __construct(PostRepository $post, CategoryRepository $category, Setting $setting)
    {
        $this->post = $post;
        $this->category = $category;
        $this->setting = $setting;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'SystemPostsWidget';
    }

    /**
     * Get the widget options
     * Possible options:
     *  x, y, width, height
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '4',
            'height' => '4',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'blog::admin.widgets.system-posts';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        $posts = $this->getPostQuery()->whereHas('categories', function(Builder $q) {
            $q->where('on_backend', true);
        })->paginate($this->setting->get('blog::latest-posts-amount', locale(), 5));
        return ['posts' => $posts];
    }
}
