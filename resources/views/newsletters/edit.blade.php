@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Newsletter</h2>
    <form action="{{ route('newsletters.update', $newsletter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $newsletter->title }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" required>{{ $newsletter->content }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image">
            @if($newsletter->image_url)
                <img src="{{ $newsletter->image_url }}" alt="Current Image" class="img-thumbnail mt-3" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
