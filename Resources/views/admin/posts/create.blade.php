@extends('layouts.master')

@section('styles')
{!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
<link href="{{{ Module::asset('blog:css/selectize.css') }}}" rel="stylesheet" type="text/css" />
<link href="{{{ Module::asset('blog:vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}}" rel="stylesheet" type="text/css" />
@stop

@section('content-header')
<h1>
    {{ trans('blog::post.title.create post') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.blog.post.index') }}">{{ trans('blog::post.title.post') }}</a></li>
    <li class="active">{{ trans('blog::post.title.create post') }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['admin.blog.post.store'], 'method' => 'post']) !!}
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            @include('partials.form-tab-headers', ['fields' => ['title', 'slug']])
            <div class="tab-content">
                <?php $i = 0; ?>
                <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                    <?php $i++; ?>
                    <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                        @include('blog::admin.posts.partials.create-fields', ['lang' => $locale])
                    </div>
                <?php endforeach; ?>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('blog::post.button.create post') }}</button>
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
                        <option value="{{ $id }}" {{ old('status', 0) == $id ? 'selected' : '' }}>{{ $status }}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label("published_on", trans('blog::post.form.published-on')) !!}
                    {!! Form::hidden("published_on", old("published_on")) !!}
                    <div class='input-group date' id='published_on_picker'>
                        <input type='text' class="form-control" id='published_on_picker_input' placeholder="{{ trans('blog::post.form.published-on') }}">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    {!! $errors->first("published_on", '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label("author_id", 'Author:') !!}
                    <select name="author_id" id="author_id" class="form-control">
                        <?php foreach ($users as $user): ?>
                        <option value="{{ $user->id }}" {{ old('author_id', $currentUser->id) == $user->id ? 'selected' : '' }}>{{ $user->email }}</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <?php $selected_categories = old('categories') ?>
                    {!! Form::label("categories", 'Categories:') !!}
                    <div class="checkbox-group">
                        <?php foreach ($categories as $category): ?>
                        <div class="checkbox">
                          <label>
                            <input name="categories[]" type="checkbox" value="{{ $category->id }}"
                            {{ in_array($category->id, (array) $selected_categories, false) ? 'checked' : '' }}>
                            {{ $category->name }}
                          </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class='form-group{{ $errors->has("tags") ? ' has-error' : '' }}'>
                   {!! Form::label("tags", 'Tags:') !!}
                   {{--{!! Form::text("tags", Input::old("tags"), ['class' => 'input-tags', 'placeholder' => 'Tags']) !!}--}}
                   <select name="tags[]" id="tags" class="input-tags" multiple></select>
                   {!! $errors->first("tags", '<span class="help-block">:message</span>') !!}
                </div>
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
<script src="{{ Module::asset('blog:vendor/moment/min/moment-with-locales.min.js') }}" type="text/javascript"></script>
<script src="{{ Module::asset('blog:vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        //CKEDITOR.replaceAll(function( textarea, config ) {
          //  config.language = '<?= App::getLocale() ?>';
        //} );
    });
    function updatePublishedOn() {
        var publishedOn = $('#published_on_picker').data('DateTimePicker').date();
        $('#published_on').val(publishedOn.toISOString());
        debugger;
    }

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

        $('#published_on_picker').datetimepicker({
            defaultDate: moment.utc().toDate(),
            locale: '<?= App::getLocale() ?>'
        }).on('dp.change', updatePublishedOn);
    });
    $(document).on('submit', 'form', updatePublishedOn);
</script>
@stop
