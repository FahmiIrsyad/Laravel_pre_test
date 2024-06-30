@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Newsletters') }}</div>

                <div class="card-body">
                    <a href="{{ route('newsletters.create') }}" class="btn btn-primary mb-3">Create Newsletter</a>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsletters as $newsletter)
                                <tr>
                                    <td>{{ $newsletter->title }}</td>
                                    <td>{{ $newsletter->content }}</td>
                                    <td>
                                        <a href="{{ route('newsletters.edit', $newsletter->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('newsletters.destroy', $newsletter->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deleted Newsletters Section -->
            <div class="card mt-4">
                <div class="card-header">{{ __('Deleted Newsletters') }}</div>

                <div class="card-body">
                    @if (session('recovered'))
                        <div class="alert alert-success">
                            {{ session('recovered') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedNewsletters as $newsletter)
                                <tr>
                                    <td>{{ $newsletter->title }}</td>
                                    <td>{{ $newsletter->content }}</td>
                                    <td>
                                        <form action="{{ route('newsletters.recover', $newsletter->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">Recover</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this newsletter?');
    }
</script>
@endsection
