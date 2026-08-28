@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="page-head">
        <h1>Gallery</h1>
        <p>Public images, newest first. Sign in to upload.</p>
    </div>

    @if ($images->isEmpty())
        <p class="empty">No images yet.</p>
    @else
        <ul class="grid">
            @foreach ($images as $image)
                <li>
                    <a class="card" href="{{ route('images.show', $image) }}">
                        <img src="{{ $image->url() }}" alt="{{ $image->title }}">
                        <span>{{ $image->title }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
