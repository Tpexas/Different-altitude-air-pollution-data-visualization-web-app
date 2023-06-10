@extends('layout')

@section('content')
<div class="grid lg:grid-cols-2 gap-4 grid-cols-1  max-w-7xl mx-auto px-2">
    <p class="text-center text-2xl font-semibold lg:col-span-2 pt-3">Naujausios oro taršos ataskaitos</p>

    @unless (count($reports) == 0)

    @foreach ($reports as $report)


    <a href="/ataskaitos/{{ $report->id }}">
        <div class="bg-gray-50 border border-gray-200 rounded p-6 col-span-1 hover:bg-gray-200">
            <div class="flex justify-between">

                <div>
                    <h3 class="text-2xl flex">
                        <p class="font-bold">{{ $report->pavadinimas }}</p>
                        <p class="text-xl self-center">, Autorius {{$report->user['name']}}</p>

                    </h3>

                </div>
            </div>
        </div>
    </a>



    @endforeach
    @else
    <p>Nieko nerasta</p>

    @endunless

</div>

<div class="mt-4 p-4">
    {{ $reports->links() }}
</div>

<x-footer />
@endsection