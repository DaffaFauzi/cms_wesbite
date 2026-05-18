@extends('layouts.admin')

@php
    $title = 'Profile Settings';
@endphp

@section('content')

<div class="space-y-8">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Account Profile</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your account information, security settings, and personal details.</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        {{-- Profile Info --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-sm font-semibold text-slate-900">Profile Information</h3>
                <p class="text-xs text-slate-500 mt-1">Update your account's profile information and email address.</p>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Security --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-sm font-semibold text-slate-900">Update Password</h3>
                <p class="text-xs text-slate-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-red-50 bg-red-50/30">
                <h3 class="text-sm font-semibold text-red-900">Danger Zone</h3>
                <p class="text-xs text-red-600/70 mt-1">Permanently delete your account and all associated data.</p>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
