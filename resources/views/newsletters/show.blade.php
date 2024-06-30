@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Latest Newsletters') }}</div>
                <div class="card-body">
                    <ul id="newsletter-list">
                        <!-- Newsletters will be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
@endsection
