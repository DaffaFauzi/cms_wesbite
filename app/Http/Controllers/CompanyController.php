<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::withCount(['pages', 'users']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $companies = $query->latest()->paginate(12)->withQueryString();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'slug'            => ['nullable', 'string', 'max:100', 'unique:companies,slug'],
            'primary_color'   => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'font_family'     => ['nullable', 'string', 'max:100'],
        ]);

        Company::create([
            'name'            => $request->name,
            'slug'            => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'primary_color'   => $request->primary_color   ?? '#4f46e5',
            'secondary_color' => $request->secondary_color ?? '#7c3aed',
            'font_family'     => $request->font_family      ?? 'Inter',
        ]);

        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return redirect()->route('companies.edit', $company);
    }

    public function edit(Company $company)
    {
        $company->loadCount(['pages', 'users']);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'slug'            => ['nullable', 'string', 'max:100', 'unique:companies,slug,' . $company->id],
            'primary_color'   => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'font_family'     => ['nullable', 'string', 'max:100'],
        ]);

        $company->update([
            'name'            => $request->name,
            'slug'            => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'primary_color'   => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'font_family'     => $request->font_family,
        ]);

        return redirect()->route('companies.index')
                         ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Company deleted successfully.');
    }
}
