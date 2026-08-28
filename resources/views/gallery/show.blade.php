@extends('layouts.app')

@section('title', $image->title)

@section('content')
    <article class="show">
        <p><a href="{{ route('gallery.index') }}">&larr; Back to gallery</a></p>
        <h1>{{ $image->title }}</h1>
        <img src="{{ $image->url() }}" alt="{{ $image->title }}">
        <p class="meta">
            Uploaded {{ $image->created_at->toFormattedDateString() }}
            @if ($image->user)
                by {{ $image->user->name }}
            @endif
        </p>

        @can('delete', $image)
            <form method="POST" action="{{ route('images.destroy', $image) }}" onsubmit="return confirm('Delete this image?');">
                @csrf
                @method('DELETE')
                <button class="danger" type="submit">Delete image</button>
            </form>
        @endcan
    </article>
@endsection
