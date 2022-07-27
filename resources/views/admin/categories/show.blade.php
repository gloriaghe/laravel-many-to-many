@extends('admin.layouts.base')

@section('mainContent')

<h1>{{$category->name}}</h1>
<p>{{$category->description}}</p>
<table class="table table-striped">

    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Tags</th>

        </tr>
        <tbody>
                @php
                $posts = $category->posts()->paginate(5)
                @endphp
            @foreach ($posts as $post)
                <tr>
                    <td>
                        <a href="{{route('admin.posts.show', ['post' => $post ]) }}">
                    {{$post->title}}
                    </a>
                    </td>
                    <td>{{ $post->user->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </thead>
</table>

{{$posts->links()}}
@endsection
