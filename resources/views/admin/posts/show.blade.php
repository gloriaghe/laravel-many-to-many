@extends('admin.layouts.base')

@section('mainContent')

<h1>{{$post['title']}}</h1>
<span>Scritto da: {{$post->user->name}}</span>
<h2>{{$post['slug']}}</h2>
<img src="{{$post['image']}}" alt="{{$post['title']}}">
<div>{{$post['content']}}</div>
<br>
<div>{{$post['excerpt']}}</div>
<strong>
    @foreach ($categories as $category)
    @if ($category->id === $post->category_id)
   Categoria: {{ $category->name}}
    @endif
    @endforeach
</strong>
<span>
    Tags:

        @foreach ($post->tags as $tag)

            {{$tag->name}}

            @endforeach

</span>

@endsection