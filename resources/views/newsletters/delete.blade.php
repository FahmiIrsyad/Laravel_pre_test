@foreach ($deletedNewsletters as $newsletter)
    <div>
        <p>Title: {{ $newsletter->title }}</p>
        <p>Content: {{ $newsletter->content }}</p>
        <form action="{{ route('newsletters.recover', $newsletter->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success">Recover</button>
        </form>
    </div>
@endforeach
