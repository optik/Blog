<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('blog::post.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::post.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
       {!! Form::label("{$lang}[slug]", trans('blog::post.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", old("$lang.slug"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::post.form.slug')]) !!}
       {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
    </div>

    <textarea class="ckeditor" name="{{$lang}}[content]" rows="10" cols="80">
        {!! old("{$lang}.content") !!}
    </textarea>

    <div class='form-group{{ $errors->has("$lang.excerpt") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[excerpt]", trans('blog::post.form.excerpt')) !!}
        <textarea class="form-control" name="{{$lang}}[excerpt]" rows="4" cols="80">{!! old("{$lang}.excerpt") !!}</textarea>
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
                    {!! Form::text("{$lang}[meta_title]", old("{$lang}.meta_title"), ['class' => "form-control", 'placeholder' => trans('blog::post.form.meta-title')]) !!}
                    {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_keywords]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_keywords]", trans('blog::post.form.meta-keywords')) !!}
                    {!! Form::text("{$lang}[meta_keywords]", old("{$lang}.meta_keywords"), ['class' => "form-control", 'placeholder' => trans('blog::post.form.meta-keywords')]) !!}
                    {!! $errors->first("{$lang}[meta_keywords]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_description]", trans('blog::post.form.meta-description')) !!}
                    <textarea class="form-control" name="{{$lang}}[meta_description]" rows="10" cols="80">{{ old("$lang.meta_description") }}</textarea>
                    {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
