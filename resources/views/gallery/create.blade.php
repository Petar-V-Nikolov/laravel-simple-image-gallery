@extends('layouts.app')

@section('title', 'Upload image')

@section('content')
    <div class="form-card">
        <h1>Upload image</h1>
        <p>JPEG, PNG, WebP, or GIF. Maximum 5&nbsp;MB. Files are stored on the public disk under <code>gallery/</code>.</p>

        <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
            @csrf

            <label for="title">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required maxlength="255">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="image">Image</label>
            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/gif" required>
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">Upload</button>
        </form>
    </div>
@endsection
