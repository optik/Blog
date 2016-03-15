@extends('layouts.master')

@section('content-header')
<h1>
    {{ $post->title }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('admin.blog.post.index') }}">{{ trans('blog::post.title.post') }}</a></li>
    <li class="active">{{ trans('blog::post.title.show post') }}</li>
</ol>
@stop

@section('content')
<div class="box box-primary show-blog-post">
    <div class="box-header with-border">
        <div class="date">Published on: {{ $post->published_on }}</div>
    </div>
    <div class="box-body">

        <main>
            {!! $post->content !!}
        </main>
    </div>
</div>
@stop
