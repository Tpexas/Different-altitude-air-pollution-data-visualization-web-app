@extends('layout')

@section('content')

    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-10">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Redaguoti ataskaitą: {{ $report->id }}
                </h2>
            </header>

            <form action="/report_table/{{ $report->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="pavadinimas" class="inline-block text-lg mb-2">Pavadinimas</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full"
                        name="pavadinimas" value="{{ $report->pavadinimas }}"/>
                        @error('pavadinimas')
                            <p class="text-red-500 text-xs mt-1">Įveskite pavadinimą</p>
                        @enderror
                </div>

                <div class="mb-6">
                    <label
                        for="aprasymas" class="inline-block text-lg mb-2">
                        Aprašymas
                    </label>
                    <textarea
                        class="border border-gray-200 rounded p-2 w-full"
                        name="aprasymas"
                        rows="10">{{ $report->aprasymas }}</textarea>
                </div>

                <div class="mb-6 text-center" >
                    <button class="bg-laravel rounded py-2 px-4">
                        Atnaujinti ataskaitą
                    </button>
                    <a href="/report_table" class="text-black ml-4"> Grįžti </a>
                </div>
            </form>
        </div>
    </div>
     @endsection

