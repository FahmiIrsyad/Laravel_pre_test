<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Newsletters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .newsletter-container {
            margin-top: 50px;
        }
        .newsletter-item {
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
            display: flex;
            align-items: center;
        }
        .newsletter-item img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }
        .newsletter-item h5 {
            margin-bottom: 5px;
        }
        .newsletter-item p {
            margin: 0;
        }
        .timestamp {
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container newsletter-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">{{ __('Latest Newsletters') }}</div>
                    <div class="card-body">
                        <ul id="newsletter-list" class="list-unstyled">
                            @forelse($newsletters as $newsletter)
                                <li class="newsletter-item">
                                    <img src="{{ $newsletter->image_url }}" alt="Newsletter Image">
                                    <div>
                                        <h5>{{ $newsletter->title }}</h5>
                                        <p>{{ $newsletter->content }}</p>
                                        <div class="timestamp">{{ $newsletter->created_at->diffForHumans() }}</div>
                                    </div>
                                </li>
                            @empty
                                <li>No newsletters found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
