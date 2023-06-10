@extends('layout')
@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')

<form action="/ataskaitos/palyginti" method="POST">
    @csrf
    <div class="mb-6">
        <label for="report" class="inline-block text-lg mb-2">Pasirinkite dvi ataskaitas iš sąrašo, kurias norite
            palyginti</label>
        <select style="width:100%" class="border border-gray-200 rounded p-2 w-full js-example-basic-multiple"
            name="report[]" id="report" multiple="multiple">
            <@foreach($reports as $report) <option value="{{ $report->id }}">{{ $report->pavadinimas
                }}
                </option>
                @endforeach
        </select>
        @error('report')
        <p class="text-red-500 text-xs mt-1">Pasirinkite bent vieną kategoriją</p>
        @enderror
    </div>
    <button class="bg-green rounded py-2 px-4">
        palyginti
    </button>
</form>

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2({
            maximumSelectionLength: 2,
            closeOnSelect: false
        });
        $('.js-example-basic-multiple').select2('open');
    });

</script>

<x-footer />
@endsection