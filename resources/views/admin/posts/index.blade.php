@extends('admin.layouts.base')

@section('mainContent')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Slug</th>
                <th>Title</th>
                <th>Author</th>
                <th>Birth</th>
                <th>Category</th>
                <th>Tags</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr data-id="{{ $post->id }}">
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->user->userDetails->birth }}</td>
                    <td><a href="{{route('admin.categories.show', ['category' => $post->category])}}">
                    {{ $post->category->name }}
                    </a>
                    <td>
                        @foreach($post->tags as $tag)
                        <a href="{{route('admin.tags.show', ['tag' => $tag])}}">{{$tag->name}}</a>
                            @if (!$loop->last), @endif
                        @endforeach
                    </td>
                    {{-- <td>{{ $post->tags->pluck('name')->join(',', 'and') }}</td> --}}
                    <td>
                        <a href="{{ route('admin.posts.show', ['post' => $post]) }}" class="btn btn-primary">View</a>
                    </td>
                    @if(Auth::id() == $post->user_id)
                    <td>
                        <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.posts.destroy', ['post' => $post]) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger"  type="submit">Delete</button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}

    {{-- <section class="overlay d-none">
        <form class="popup" data-action="{{ route('admin.posts.destroy', ['post' => '*****']) }}" method="post">
            @csrf
            @method('DELETE')

            <h1>Sei sicuro?</h1>
            <button type="submit" class="btn btn-warning js-yes">Yes</button>
            <button type="button" class="btn btn-danger js-no">No</button>
        </form>
    </section> --}}
@endsection
