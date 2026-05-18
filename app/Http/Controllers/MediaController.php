<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $user      = auth()->user();
        $isSuper   = $user->role === 'super_admin';
        $companyId = session('company_id');

        $media = $isSuper
            ? Media::with('company')->latest()->paginate(24)
            : Media::where('company_id', $companyId)->latest()->paginate(24);

        return view('media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'       => ['required', 'file', 'image', 'max:5120'], // 5 MB
            'company_id' => ['nullable', 'exists:companies,id'],
        ]);

        $user      = auth()->user();
        $isSuper   = $user->role === 'super_admin';
        $companyId = $isSuper
            ? ($request->company_id ?? session('company_id'))
            : session('company_id');

        $file = $request->file('file');
        $path = $file->store("media/{$companyId}", 'public');

        Media::create([
            'company_id'    => $companyId,
            'file_path'     => $path,
            'file_type'     => $file->getMimeType(),
            'original_name' => $file->getClientOriginalName(),
        ]);

        return redirect()
            ->route('media.index')
            ->with('success', 'File uploaded successfully.');
    }

    public function destroy(Media $medium)
    {
        // Authorize
        $user = auth()->user();
        if ($user->role !== 'super_admin' && $medium->company_id !== session('company_id')) {
            abort(403, 'Unauthorized');
        }

        // Delete file from disk
        Storage::disk('public')->delete($medium->file_path);

        $medium->delete();

        return redirect()
            ->route('media.index')
            ->with('success', 'Media deleted.');
    }
}
