<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />


  {{--
  <link rel="icon" href="images/favicon.ico" /> --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script> --}}
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  @yield('scripts')
  @vite(['resources/css/app.css', 'resources/js/app.js'])





  {{--
  <link href="{{ asset('build/assets/app-7301fcb8.css') }}" rel="stylesheet">
  <script src="{{ asset('build/assets/app-8da90743.js') }}" defer></script> --}}


  <title>ReportsApp</title>
</head>

<body class="mb-12 bg-gradient-to-r from-rose-100 to-teal-100">
  <!-- ====== Navbar Section Start -->
  <header class="py-6 bg-white/50">
    <nav class="flex sm:justify-between justify-center flex-wrap max-w-7xl mx-auto">
      <div class="py-6">
        <a href="/" class="text-dark hover:text-primary py-3 px-7 text-base font-bold">
          Pradžia
        </a>
      </div>

      <div class="flex flex-wrap justify-center">
        @include('partials._search')
        @auth

        <span class="font-bold uppercase py-6 px-3"> Sveiki, {{ auth()->user()->name }}</span>
        <div class="py-6">
          <a href="/ataskaitos/tvarkymas" class="py-3 px-3 font-bold text-base">
            <i class="fa-solid fa-gear"></i>
            Ataskaitų tvarkymas
          </a>
        </div>
        <div class="py-3">
          <form action="/atsijungti" method="POST" class="">
            @csrf
            <button type="submit"
              class="font-bold text-base border-y mx-2 border-black/25 rounded-none hover:bg-gray-200 py-2.5">
              Atsijungti</button>
          </form>
        </div>
        @else
        <div class="py-6">
          <a href="/prisijungti" class="text-dark hover:text-primary py-3 px-7 text-base font-bold">
            Prisijungti
          </a>
        </div>
        <div class="py-6">
          <a href="/registracija" class="text-dark hover:text-primary py-3 px-7 text-base font-bold">
            Registracija
          </a>
        </div>


        @endauth
      </div>
    </nav>

    {{-- <div class="flex w-full items-center justify-between px-4">
      <div>
        <nav
          class="absolute right-4 top-full w-full max-w-[250px] rounded-lg py-5 px-6 shadow lg:static lg:block lg:w-full lg:max-w-full lg:shadow-none">
          <ul class="block lg:flex">
            <li>
              <a href="/"
                class="text-dark hover:text-primary flex py-2 text-base font-semibold lg:ml-12 lg:inline-flex">
                Pradžia
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="flex">
        @auth
        <span class="font-bold uppercase py-3 px-3"> Sveiki, {{ auth()->user()->name }}</span>
        <a href="/ataskaitos/tvarkymas"
          class="rounded-lg py-3 px-3 font-bold text-base hover:text-cyan-800 hover:bg-opacity-90">
          <i class="fa-solid fa-gear"></i>
          Ataskaitų tvarkymas
        </a>
        <div>
          <form action="/atsijungti" method="POST" class="py-3 px-3 ">
            @csrf
            <button type="submit" class="font-bold text-base hover:text-cyan-800 hover:bg-opacity-90">
              <i class="fa-solid fa-door-closed"></i> Atsijungti</button>
          </form>
        </div>
        @else
        <a href="/prisijungti" class="text-dark hover:text-primary py-3 px-7 text-base font-bold">
          Prisijungti
        </a>
        <a href="/registracija" class=" rounded-lg py-3 px-7 text-base font-bold hover:text-primary">
          Registracija
        </a>

        @endauth
        @include('partials._search')
      </div>
    </div> --}}
  </header>
  <!-- ====== Navbar Section End -->


  <main>
    @yield('content')


    <x-flash-message />
</body>

</html>