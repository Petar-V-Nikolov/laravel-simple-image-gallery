<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function index(): View
    {
        $images = Image::query()->latest()->get();

        return view('gallery.index', compact('images'));
    }

    public function show(Image $image): View
    {
        return view('gallery.show', compact('image'));
    }

    public function create(): View
    {
        return view('gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,webp,gif', 'max:5120'],
        ]);

        $file = $request->file('image');
        $mime = $file->getMimeType();
        $size = $file->getSize();
        $path = $file->store('gallery', 'public');

        Image::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'path' => $path,
            'mime' => $mime,
            'size' => $size,
        ]);

        return redirect()
            ->route('gallery.index')
            ->with('status', 'Image uploaded.');
    }

    public function destroy(Image $image): RedirectResponse
    {
        $this->authorize('delete', $image);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()
            ->route('gallery.index')
            ->with('status', 'Image deleted.');
    }
}
