<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Page;

class FrontendController extends Controller
{
    public function show($company)
    {
        $company = Company::where('slug', $company)->firstOrFail();

        $page = Page::where('company_id', $company->id)
            ->where('slug', 'home')
            ->firstOrFail();

        $sections = $page->sections()
            ->orderBy('order')
            ->get();

        return view('frontend.home', compact('company', 'page', 'sections'));
    }
}