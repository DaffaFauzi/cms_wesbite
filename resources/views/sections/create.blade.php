@extends('layouts.admin')

@section('content')

<div class="w-full bg-white rounded-xl shadow p-6">

    <h1 class="text-2xl font-bold mb-6">
        Create Section
    </h1>

    <form method="POST"
          action="{{ route('pages.sections.store', $page->id) }}">

        @csrf

        <div class="mb-4">

            <label class="block mb-2 font-medium">
                Type
            </label>

            <select name="type"
                    class="w-full border rounded-lg px-3 py-2">

                <option value="hero">Hero</option>
                <option value="about">About</option>
                <option value="services">Services</option>
                <option value="gallery">Gallery</option>
                <option value="contact">Contact</option>

            </select>

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-medium">
                Order
            </label>

            <input type="number"
                   name="order"
                   value="1"
                   class="w-full border rounded-lg px-3 py-2">

        </div>

        <div class="mb-6">

            <label class="block mb-2 font-medium">
                Content (JSON)
            </label>

            <textarea name="content"
                      rows="10"
                      class="w-full border rounded-lg px-3 py-2"></textarea>

        </div>

        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
            Create Section
        </button>

    </form>

</div>

@endsection