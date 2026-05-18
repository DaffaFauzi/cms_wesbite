<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $user      = auth()->user();
        $isSuper   = $user->role === 'super_admin';
        $companyId = session('company_id');

        $query = Page::with('company')->latest();

        if (! $isSuper) {
            $query->where('company_id', $companyId);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $pages = $query->paginate(12)->withQueryString();

        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        $companies = auth()->user()->role === 'super_admin'
            ? Company::all()
            : null;

        return view('pages.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_published'     => ['nullable', 'boolean'],
            'company_id'       => ['nullable', 'exists:companies,id'],
        ]);

        $companyId = auth()->user()->role === 'super_admin'
            ? $request->company_id
            : session('company_id');

        Page::create([
            'company_id'       => $companyId,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title),
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_published'     => $request->boolean('is_published'),
        ]);

        return redirect()->route('pages.index')
                         ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        $this->authorizePage($page);
        return redirect()->route('pages.edit', $page);
    }

    public function edit(Page $page)
    {
        $this->authorizePage($page);

        $companies = auth()->user()->role === 'super_admin'
            ? Company::all()
            : null;

        return view('pages.edit', compact('page', 'companies'));
    }

    public function update(Request $request, Page $page)
    {
        $this->authorizePage($page);

        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_published'     => ['nullable', 'boolean'],
            'company_id'       => ['nullable', 'exists:companies,id'],
        ]);

        $companyId = auth()->user()->role === 'super_admin'
            ? $request->company_id
            : $page->company_id;

        $page->update([
            'company_id'       => $companyId,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title),
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_published'     => $request->boolean('is_published'),
        ]);

        return redirect()->route('pages.index')
                         ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->authorizePage($page);
        $page->delete();

        return redirect()->route('pages.index')
                         ->with('success', 'Page deleted.');
    }

    private function authorizePage(Page $page): void
    {
        if (auth()->user()->role !== 'super_admin'
            && $page->company_id !== session('company_id')) {
            abort(403, 'Unauthorized');
        }
    }
}