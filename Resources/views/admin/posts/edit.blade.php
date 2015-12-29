@extends('layouts.master')

@section('styles')
{!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
<link href="{{{ Module::asset('blog:css/selectize.css') }}}" rel="stylesheet" type="text/css" />
@stop

@section('content-header')
<h1>
    {{ trans('blog::post.title.edit post') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.blog.category.index') }}">{{ trans('blog::post.title.post') }}</a></li>
    <li class="active">{{ trans('blog::post.title.edit post') }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['admin.blog.post.update', $post->id], 'method' => 'put']) !!}

<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            @include('partials.form-tab-headers', ['fields' => ['title', 'slug']])
            <div class="tab-content">
                <?php $i = 0; ?>
                <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                    <?php $i++; ?>
                    <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                        @include('blog::admin.posts.partials.edit-fields', ['lang' => $locale])
                    </div>
                <?php endforeach; ?>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.blog.post.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div> {{-- end nav-tabs-custom --}}
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label("status", 'Post status:') !!}
                    <select name="status" id="status" class="form-control">
                        <?php foreach ($statuses as $id => $status): ?>
                        <option value="{{ $id }}" {{ old('status', $post->status) == $id ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label("author_id", 'Author:') !!}
                    <select name="author_id" id="author_id" class="form-control">
                        <?php foreach ($users as $user): ?>
                        <option value="{{ $user->id }}" {{ old('author_id', $post->author_id) == $user->id ? 'selected' : '' }}>{{ $user->email }}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php $selected_categories = old('categories', $post->categories->lists('id')->all()) ?>
                    {!! Form::label("categories", 'Categories:') !!}
                    <?php foreach ($categories as $category): ?>
                    <div class="checkbox">
                      <label>
                        <input name="categories[]" type="checkbox" value="{{ $category->id }}"
                        {{ in_array($category->id, (array)$selected_categories, false) ? 'checked' : '' }}>
                        {{ $category->name }}
                      </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class='form-group{{ $errors->has("tags") ? ' has-error' : '' }}'>
                    {!! Form::label("tags", 'Tags:') !!}
                    <select name="tags[]" id="tags" class="input-tags" multiple>
                        <?php foreach ($post->tags()->get() as $tag): ?>
                            <?php $tagName = $tag->hasTranslation(locale()) === true ? $tag->translate(locale())->name : 'Not translated';  ?>
                            <option value="{{ $tag->id }}" selected>{{ $tagName }}</option>
                        <?php endforeach; ?>
                    </select>
                    {!! $errors->first("tags", '<span class="help-block">:message</span>') !!}
                </div>
                @include('media::admin.fields.file-link', [
                    'entityClass' => 'Modules\\\\Blog\\\\Entities\\\\Post',
                    'entityId' => $post->id,
                    'zone' => 'thumbnail'
                ])
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index', ['name' => 'posts']) }}</dd>
    </dl>
@stop

@section('scripts')
<script src="{{ Module::asset('blog:js/selectize.min.js') }}" type="text/javascript"></script>
<script src="{{ Module::asset('blog:js/MySelectize.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        //CKEDITOR.replaceAll(function( textarea, config ) {
//            console.log(textarea);
//            config.language = '<?= App::getLocale() ?>';
//        } );
    });
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'b', route: "<?= route('admin.blog.post.index') ?>" }
            ]
        });

        $('.input-tags').MySelectize({
            'findUri' : '<?= route('api.tag.findByName') ?>/',
            'createUri' : '<?= route('api.tag.store') ?>',
            'token': '<?= csrf_token() ?>'
        });
    });
</script>
@stop
