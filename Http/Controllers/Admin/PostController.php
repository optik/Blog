<?php namespace Modules\Blog\Http\Controllers\Admin;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\Status;
use Modules\Blog\Http\Requests\CreatePostRequest;
use Modules\Blog\Http\Requests\UpdatePostRequest;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Repositories\PostRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Core\Contracts\Authentication;

class PostController extends AdminBaseController
{
    /**
     * @var PostRepository
     */
    private $post;
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var Status
     */
    private $status;

    public function __construct(
        PostRepository $post,
        CategoryRepository $category,
        FileRepository $file,
        UserRepository $user,
        Authentication $auth,
        Status $status
    ) {
        parent::__construct();

        $this->post = $post;
        $this->category = $category;
        $this->file = $file;
        $this->user = $user;
        $this->auth = $auth;
        $this->status = $status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->post->all();

        return view('blog::admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = $this->getAuthors();
        $currentUser = $this->auth->check();
        $categories = $this->category->allTranslatedIn(app()->getLocale());
        $statuses = $this->status->lists();

        return view('blog::admin.posts.create', compact('currentUser', 'users', 'categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePostRequest $request)
    {
        $this->post->create($request->all());

        flash(trans('blog::messages.post created'));

        return redirect()->route('admin.blog.post.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $users = $this->getAuthors();
        $thumbnail = $this->file->findFileByZoneForEntity('thumbnail', $post);
        $categories = $this->category->allTranslatedIn(app()->getLocale());
        $statuses = $this->status->lists();

        return view('blog::admin.posts.edit', compact('currentUser', 'users', 'post', 'categories', 'thumbnail', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Post $post
     * @param UpdatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->post->update($post, $request->all());

        flash(trans('blog::messages.post updated'));

        return redirect()->route('admin.blog.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->categories()->detach();

        $this->post->destroy($post);

        flash(trans('blog::messages.post deleted'));

        return redirect()->route('admin.blog.post.index');
    }

    /**
     * Get all users with blog post author permissions
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAuthors()
    {
        return $this->user->all()->filter(function($user) {
            return $user->hasAccess('blog.posts.store', 'blog.posts.update');
        });
    }
}
