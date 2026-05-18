<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index($pageId)
    {
        $page = Page::with('company')->findOrFail($pageId);
        $this->authorizePage($page);

        $sections = Section::where('page_id', $pageId)
            ->orderBy('order')
            ->get();

        return view('sections.index', compact('page', 'sections'));
    }

    public function create($pageId)
    {
        $page = Page::findOrFail($pageId);
        $this->authorizePage($page);

        return view('sections.create', compact('page'));
    }

    public function store(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);
        $this->authorizePage($page);

        $request->validate([
            'type'    => ['required', 'string', 'in:hero,about,services,gallery,contact'],
            'content' => ['nullable', 'string'],
            'order'   => ['required', 'integer', 'min:0'],
        ]);

        // Validate JSON
        $content = null;
        if ($request->filled('content')) {
            $decoded = json_decode($request->content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors(['content' => 'Content must be valid JSON.']);
            }
            $content = $decoded;
        }

        Section::create([
            'page_id' => $pageId,
            'type'    => $request->type,
            'content' => $content,
            'order'   => $request->order,
        ]);

        return redirect()
            ->route('pages.sections.index', $pageId)
            ->with('success', 'Section created successfully.');
    }

    public function edit($pageId, $sectionId)
    {
        $page    = Page::findOrFail($pageId);
        $section = Section::findOrFail($sectionId);
        $this->authorizePage($page);

        return view('sections.edit', compact('page', 'section'));
    }

    public function update(Request $request, $pageId, $sectionId)
    {
        $page    = Page::findOrFail($pageId);
        $section = Section::findOrFail($sectionId);
        $this->authorizePage($page);

        $request->validate([
            'type'    => ['required', 'string', 'in:hero,about,services,gallery,contact'],
            'content' => ['nullable', 'string'],
            'order'   => ['required', 'integer', 'min:0'],
        ]);

        $content = null;
        if ($request->filled('content')) {
            $decoded = json_decode($request->content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors(['content' => 'Content must be valid JSON.']);
            }
            $content = $decoded;
        }

        $section->update([
            'type'    => $request->type,
            'content' => $content,
            'order'   => $request->order,
        ]);

        return redirect()
            ->route('pages.sections.index', $pageId)
            ->with('success', 'Section updated successfully.');
    }

    public function destroy($pageId, $sectionId)
    {
        $page    = Page::findOrFail($pageId);
        $section = Section::findOrFail($sectionId);
        $this->authorizePage($page);

        $section->delete();

        return redirect()
            ->route('pages.sections.index', $pageId)
            ->with('success', 'Section deleted.');
    }

    private function authorizePage(Page $page): void
    {
        $user = auth()->user();
        if ($user->role !== 'super_admin' && $page->company_id !== session('company_id')) {
            abort(403, 'Unauthorized');
        }
    }
}