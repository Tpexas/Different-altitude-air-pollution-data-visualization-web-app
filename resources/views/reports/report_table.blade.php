@extends('layout')

@section('content')

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Pavadinimas
                </th>
                <th scope="col" class="px-6 py-3">
                    Aprašymas
                </th>
                <th scope="col" class="px-6 py-3">
                    has_sensor_data
                </th>
                <th scope="col" class="px-6 py-3">
                    has_drone_data
                </th>
                <th scope="col" class="px-6 py-3">
                    veiksmai
                </th>
            </tr>
        </thead>

        @unless (count($reports) == 0)

        @foreach ($reports as $report)
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $report->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $report->pavadinimas }}
                </td>
                <td class="px-6 py-4">
                    {{ $report->aprasymas }}
                </td>
                <td class="px-6 py-4">
                    {{ $report->has_sensor_data }}
                </td>
                <td class="px-6 py-4">
                    {{ $report->has_drone_data }}
                </td>
                <td class="px-6 py-4">
                    <a type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300
                     font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700
                      dark:focus:ring-blue-800" href="/ataskaitos/{{$report->id}}/redaguoti">Redaguoti</a>

                    <form method="POST" action="/ataskaitos/{{ $report->id }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4
                     focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700
                      dark:focus:ring-red-900"
                            onclick="return confirm('Ar tikrai norite ištrinti ID:{{ $report->id }}?')">Ištrinti</button>

                    </form>
                </td>

            </tr>
        </tbody>
        @endforeach

        @else
        <tr>Nieko nerasta</tr>

        @endunless
    </table>
</div>

<div class="mt-4 p-4">
    {{ $reports->links() }}
</div>

@endsection