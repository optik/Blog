<div class="system-posts-widget box box-primary">
    <div class="box-header">
        <h3 class="box-title">{{ trans('blog::post.system posts') }}</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if (isset($posts)): ?>
            <ol class="list-unstyled">
                <?php foreach ($posts as $post): ?>
                    <li>
                        <h4>{{ $post->title }}</h4>
                        <small class="date">{{ $post->created_at }}</small>
                        <div class="excerpt">
                            {!! $post->excerpt !!}
                        </div>
                        <a class="read-more" href="{{ route('admin.blog.post.show', [$post->id]) }}">Read more</a>
                    </li>
                <?php endforeach ?>
            </ol>
        <?php endif ?>
    </div><!-- /.box-body -->
</div>
