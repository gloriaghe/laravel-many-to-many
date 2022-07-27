@extends('admin.layouts.base')

@section('mainContent')

<h1>{{$post['title']}}</h1>
<span>Scritto da: {{$post->user->name}}</span>
<h2>{{$post['slug']}}</h2>
<img src="{{$post['image']}}" alt="{{$post['title']}}">
<div>{{$post['content']}}</div>
<br>
<div>{{$post['excerpt']}}</div>
<br>
<div>
    @foreach ($categories as $category)
    @if ($category->id === $post->category_id)
        <strong>Categoria:</strong>
        <span>{{ $category->name}}</span>
    @endif
    @endforeach
</div>
<br>
<div>
    <strong>Tags:</strong>

        @foreach ($post->tags as $tag)
            <span>{{$tag->name}}</span>
        @endforeach

</div>

@endsection
