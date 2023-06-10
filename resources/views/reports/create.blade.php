@extends('layout')

@section('content')

    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-10">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Kurti ataskaitą
                </h2>
            </header>

            <form action="/ataskaitos/issaugoti" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label for="pavadinimas" class="inline-block text-lg mb-2">Pavadinimas</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full"
                        name="pavadinimas" value="{{ old('pavadinimas') }}"/>
                        @error('pavadinimas')
                            <p class="text-red-500 text-xs mt-1">Įveskite pavadinimą</p>
                        @enderror
                </div>

                <div class="mb-6">
                    <label for="sensor_data" class="inline-block text-lg mb-2">
                        Arduino csv failas
                    </label>
                    <input type="file" class="border border-gray-200 rounded p-2 w-full" name="sensor_data"/>
                    @error('sensor_data')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="mb-6">
                    <label for="drone_data" class="inline-block text-lg mb-2">
                        Drono csv failas
                    </label>
                    <input type="file" class="border border-gray-200 rounded p-2 w-full" name="drone_data"/>
                    @error('drone_data')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                        rows="10">{{ old('aprasymas') }}</textarea>
                </div>

                <div class="mb-6 text-center" >
                    <button class="bg-laravel rounded py-2 px-4">
                        Kurti ataskaitą
                    </button>
                    <a href="/" class="text-black ml-4"> Grįžti </a>
                </div>
            </form>
        </div>
    </div>
     @endsection

