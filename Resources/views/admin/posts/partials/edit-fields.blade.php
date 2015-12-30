<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        <?php $oldTitle = isset($post->translate($lang)->title) ? $post->translate($lang)->title : ''; ?>
        {!! Form::label("{$lang}[title]", trans('blog::post.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title", $oldTitle), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::post.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
        <?php $oldSlug = isset($post->translate($lang)->slug) ? $post->translate($lang)->slug : ''; ?>
       {!! Form::label("{$lang}[slug]", trans('blog::post.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", old("$lang.slug", $oldSlug), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::post.form.slug')]) !!}
       {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
        <?php $oldContent = isset($post->translate($lang)->content) ? $post->translate($lang)->content : ''; ?>
        <textarea class="ckeditor" name="{{$lang}}[content]" rows="10" cols="80">
        {!! old("{$lang}.content", $oldContent) !!}
        </textarea>
    </div>

    <div class='form-group{{ $errors->has("$lang.excerpt") ? ' has-error' : '' }}'>
        <?php $oldExcerpt = isset($post->translate($lang)->excerpt) ? $post->translate($lang)->excerpt : ''; ?>
        {!! Form::label("{$lang}[excerpt]", trans('blog::post.form.excerpt')) !!}
        <textarea class="form-control" name="{{$lang}}[excerpt]" rows="4" cols="80">{!! old("{$lang}.excerpt", $oldExcerpt) !!}</textarea>
    </div>
</div>

<div class="box-group" id="accordion">
    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
    <div class="panel box box-primary">
        <div class="box-header">
            <h4 class="box-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                    {{ trans('page::pages.form.meta_data') }}
                </a>
            </h4>
        </div>
        <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
            <div class="box-body">
                <div class='form-group{{ $errors->has("{$lang}[meta_title]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_title]", trans('blog::post.form.meta-title')) !!}
                    <?php $old = $post->hasTranslation($lang) ? $post->translate($lang)->meta_title : '' ?>
                    {!! Form::text("{$lang}[meta_title]", old("{$lang}.meta_title", $old), ['class' => "form-control", 'placeholder' => trans('blog::post.form.meta-title')]) !!}
                    {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_keywords]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_keywords]", trans('blog::post.form.meta-keywords')) !!}
                    <?php $old = $post->hasTranslation($lang) ? $post->translate($lang)->meta_keywords : '' ?>
                    {!! Form::text("{$lang}[meta_keywords]", old("{$lang}.meta_keywords", $old), ['class' => "form-control", 'placeholder' => trans('blog::post.form.meta-keywords')]) !!}
                    {!! $errors->first("{$lang}[meta_keywords]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_description]", trans('blog::post.form.meta-description')) !!}
                    <?php $old = $post->hasTranslation($lang) ? $post->translate($lang)->meta_description : '' ?>
                    <textarea class="form-control" name="{{$lang}}[meta_description]" rows="10" cols="80">{{ old("$lang.meta_description", $old) }}</textarea>
                    {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
