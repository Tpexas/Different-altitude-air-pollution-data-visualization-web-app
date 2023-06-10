<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>

    <title>ReportsApp</title>

    <style>
        #map {
            width: "100%";
            height: "100%";
        }
    </style>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


    <link href="{{ asset('build/assets/app-7301fcb8.css') }}" rel="stylesheet">
    <script src="{{ asset('build/assets/app-8da90743.js') }}" defer></script>
</head>

<body class="mb-48 bg-gradient-to-r from-rose-100 to-teal-100">
    <nav :class="!navbarOpen && 'hidden' " id="navbarCollapse"
        class="absolute right-4 top-full w-full max-w-[250px] rounded-lg bg-white py-5 px-6 shadow lg:static lg:block lg:w-full lg:max-w-full lg:shadow-none">
        <ul class="block lg:flex">
            <li>
                <a href="/"
                    class="text-dark hover:text-primary flex py-2 text-base font-medium lg:ml-12 lg:inline-flex">
                    Pradžia
                </a>
            </li>
            <li>
                <a href="javascript:void(0)"
                    class="text-dark hover:text-primary flex py-2 text-base font-medium lg:ml-12 lg:inline-flex">
                    ...///
                </a>
            </li>
            <li>
                <a href="javascript:void(0)"
                    class="text-dark hover:text-primary flex py-2 text-base font-medium lg:ml-12 lg:inline-flex">
                    ...///
                </a>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')

</body>

</html>