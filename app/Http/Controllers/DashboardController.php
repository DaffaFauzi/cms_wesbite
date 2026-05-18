<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Media;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isSuper = $user->role === 'super_admin';
        $companyId = session('company_id');

        $stats = [
            'companies' => $isSuper ? Company::count() : 1,
            'pages'     => $isSuper
                ? Page::count()
                : Page::where('company_id', $companyId)->count(),
            'sections'  => $isSuper
                ? Section::count()
                : Section::whereHas('page', fn($q) => $q->where('company_id', $companyId))->count(),
            'media'     => $isSuper
                ? Media::count()
                : Media::where('company_id', $companyId)->count(),
        ];

        $recentPages = $isSuper
            ? Page::with('company')->latest()->take(8)->get()
            : Page::with('company')
                  ->where('company_id', $companyId)
                  ->latest()
                  ->take(8)
                  ->get();

        return view('dashboard', compact('stats', 'recentPages'));
    }
}
