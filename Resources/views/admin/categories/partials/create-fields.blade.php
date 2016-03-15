<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}[name]") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[name]", trans('blog::category.form.name')) !!}
        {!! Form::text("{$lang}[name]", Input::old("{$lang}[name]"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::category.form.name')]) !!}
        {!! $errors->first("{$lang}[name]", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}[slug]") ? ' has-error' : '' }}'>
       {!! Form::label("{$lang}[slug]", trans('blog::category.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", Input::old("{$lang}[slug]"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::category.form.slug')]) !!}
       {!! $errors->first("{$lang}[slug]", '<span class="help-block">:message</span>') !!}
   </div>
   <div class="form-group{{ $errors->has('on_backend') ? ' has-error' : '' }}">
      <div class="checkbox">
         <label for="on_backend">
            {!! Form::checkbox('on_backend', old('on_backend')) !!}
            {!! trans('blog::category.form.on backend') !!}
         </label>
      </div>
      {!! $errors->first('on_backend', '<span class="help-block">:message</span>') !!}
   </div>
</div>
