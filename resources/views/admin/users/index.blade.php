@extends('admin.layouts.base')
@section('mainContent')

<table class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Birth</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr data-id="{{ $user->id }}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                @php
                    $details = $user->userDetails()->first()
                @endphp
                {{-- controlli per vedere se ci sono o meno i dati --}}
                <td>{{ $details ? ($details->address ?: '-') : '-' }}</td>
                <td>{{ $details ? ($details->phone ?: '-') : '-' }}</td>
                <td>{{ $details ? ($details->birth ?: '-') : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

 {{ $users->links() }}

{{-- <section class="overlay d-none">
    <form class="popup" data-action="{{ route('admin.user.destroy', ['user' => '*****']) }}" method="user">
        @csrf
        @method('DELETE')

        <h1>Sei sicuro?</h1>
        <button type="submit" class="btn btn-warning js-yes">Yes</button>
        <button type="button" class="btn btn-danger js-no">No</button>
    </form>
</section> --}}
@endsection
