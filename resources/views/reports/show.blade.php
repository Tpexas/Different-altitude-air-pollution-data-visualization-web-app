@extends('layout')
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://cdn.plot.ly/plotly-2.18.2.min.js"></script> --}}
<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
  integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
  integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endsection

@section('content')


<div class="px-4">
  @unless ($error == true)
  <div class="flex flex-col py-4 text-center">
    <p class="font-bold text-xl">{{$report->pavadinimas}}</p>
    <p>{{date("Y-m-d", strtotime($droneData[0]->date))}}
      {{$droneData[0]->time}}
    </p>
    <p>Autorius - {{$report->user()->first()->name}}</p>
    <div class="flex mx-auto pt-4">
      <a class="border-y mx-2 border-black/25 rounded-none hover:bg-gray-200"
        href="/ataskaitos/{{$report->id}}/3d">Vizualizacija 3D aplinkoje</a>
      <a class="border-y mx-2 border-black/25 rounded-none hover:bg-gray-200"
        href="/ataskaitos/{{$report->id}}/eksportuoti">Atisiųsti duomenų xlsx failą</a>
    </div>
  </div>

  <div>

    <div class="relative overflow-x-auto">

    </div>

  </div>



  <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
    <x-border-line class="xl:col-span-2 col-span-1">Oro kokybės lentelės</x-border-line>

    <x-text_info>Žemiau pateiktos lentelės nurodo skrydžio metu surinktus pagrindinius duomenis, pirmoje lentelėje
      nurodomos koordinatės,
      kuriose buvo aptikti aukščiausi matavimai, kitoje lentejė pateikiama bendra tyrimo informacija, toliau paaiškinami
      spalvų žymėjimai</x-text_info>

    <div class="xl:col-span-2 col-span-1 flex space-x-6">
      @foreach($location as $list)
      <div>
        <p>Vietovė: {{$list['name']}}, orų duomenys gauti
          @endforeach
          @foreach($pastWeather['list'] as $list)
        </p>
      </div>
      <div>
        <p>Vėjas {{$cardinal}} {{$windSpeed = $list['wind']['speed'];}} m/s, </p>
      </div>
      <div>
        <p>Debesuotumas: {{$list['clouds']['all']}}%</p>
      </div>
      <div>
        <p>Slėgis:
          @php if(isset($list['main']['grnd_level'])){
          echo $list['main']['grnd_level']." hPa";
          }
          else echo $list['main']['pressure']." hPa";
          @endphp
        </p>
      </div>
      @if(isset($list['rain']['1h']))
      <div>
        <p>Lietaus kiekis pastarają valandą: {{$list['rain']['1h']}} mm</p>
      </div>
      @endif
      @if(isset($list['snow']['1h']))
      <div>
        <p>Sniego kiekis pastarają valandą: {{$list['snow']['1h']}} mm</p>
      </div>
      @endif
      @endforeach
    </div>

    <div class="col-span-1 font-medium lg:flex gap-6">
      <div class="lg:w-3/5 ">
        <div class="rounded-lg overflow-hidden shadow-lg shadow-indigo-500/50">
          <p class="px-1">Aukščiausi CO2 parodymų taškai</p>
          <table class="tarsos_taskai w-full text-sm text-left">
            <thead class="uppercase border-b border-gray-700">
              <tr>
                <th scope=" col" class="py-4">
                  Ilguma
                </th>
                <th scope="col" class="py-4">
                  Platuma
                </th>
                <th scope="col" class="py-4">
                  Aukštis
                </th>
                <th scope="col" class="py-4">
                  CO2 (PPM)
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($maxPollution as $row)
              <tr
                class="border-b border-gray-700 @include('components.case', ['data' => $row->sensor1, 'limits' => [400,1000,2000,5000,40000]])">
                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                  {{$row->latitude}}
                </th>
                <td class="py-4">
                  {{$row->longitude}}
                </td>
                <td class="py-4">
                  {{$row->altitude}}
                </td>
                <td class="py-4">
                  {{$row->sensor1}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="tarsos_taskai w-2/5 pt-6 ">
        <table class="w-full text-sm text-left rounded-lg overflow-hidden shadow-lg shadow-indigo-500/50">
          <tbody>
            <thead class=" uppercase border-b border-gray-700">
              <tr>
                <th scope=" col" class="py-4">
                  Bendra informacija
                </th>
              </tr>
            </thead>
            <tr
              class="border-b border-gray-700 @include('components.case', ['data' => $highestPollution, 'limits' => [400,1000,2000,5000,40000]])">
              <th scope="row" class="py-4 font-medium  ">
                Aukščiausia užfiksuota reikšmė:
              </th>
              <th scope="row" class="py-4 font-medium  ">
                {{$highestPollution}} PPM
              </th>

            <tr
              class="border-b border-gray-700 @include('components.case', ['data' => $minPollution, 'limits' => [400,1000,2000,5000,40000]])">
              <th scope="row" class="py-4 font-medium  ">
                Mažiausia užfiksuota reikšmė:
              </th>
              <th scope="row" class="py-4 font-medium  ">
                {{$minPollution}} PPM
              </th>

            <tr class="border-b border-gray-700
            @include('components.case', ['data' => $avgPollution, 'limits' => [400,1000,2000,5000,40000]])">
              <th scope="row" class="py-4 font-medium  ">
                Vidutinė matavimų reikšmė:
              </th>
              <th scope="row" class="py-4 font-medium  ">
                {{$avgPollution}} PPM
              </th>
            <tr class="bg-white border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  ">
                Skrydžio trukmė:
              </th>
              <th scope="row" class="py-4 font-medium  ">
                {{gmdate("H:i:s", $flightTime)}}
              </th>
            <tr class="bg-white border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  ">
                Vidutinė temperatūra ir drėgmė:
              </th>
              <th scope="row" class="py-4 font-medium  ">
                {{$avgTemp}} °C, {{$avgHumidity}}%
              </th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-span-1 font-medium gap-6 flex ">
      <div class="w-full rounded-lg overflow-hidden shadow-lg shadow-indigo-500/50">
        <p>Oro kokybės lygiai</p>
        <table class="w-full text-sm text-left">
          <thead class=" uppercase border-b border-gray-700">
            <tr>
              <th scope=" col" class="px-2 py-4">
                Spalva
              </th>
              <th scope="col" class="px-2 py-4">
                Poveikis sveikatai (pagal Aplinkos apsaugos agentūrą)
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-aqi_green border-b border-gray-700">
              <th scope="row" class="px-2 py-4 font-medium ">
                Žalia
              </th>
              <th scope="row" class="px-2 py-4 font-medium ">
                Oro kokybė gera, galite mėgautis švariu oru.
              </th>

            <tr class="bg-aqi_yellow border-b border-gray-700">
              <th scope="row" class="px-2 py-4 font-medium ">
                Geltona
              </th>
              <th scope="row" class="px-2 py-4 font-medium ">
                Oro kokybė gera, galite mėgautis švariu oru.
              </th>

            <tr class="bg-aqi_orange text-white border-b border-gray-700">
              <th scope="row" class="px-2 py-4 font-medium ">
                Oranžinė
              </th>
              <th scope="row" class="px-2 py-4 font-medium ">
                Jautrios gyventojų grupės (vaikai, vyresnio amžiaus žmonės, nėščios moterys ) turėtų vengti ilgesnių
                pasivaikščiojimų ar kitos aktyvesnės veiklos prie intensyvaus eismo gatvių, sankryžų.
              </th>
            <tr class="bg-aqi_red text-white border-b border-gray-700">
              <th scope="row" class="px-2 py-4 font-medium  ">
                Raudona
              </th>
              <th scope="row" class="px-2 py-4 font-medium ">
                Aktyvia veikla atvirame ore gali užsiimti tik visiškai sveiki žmonės; siekiant išvengti dar didesnio oro
                užterštumo, rekomenduojama nevažiuoti savu automobiliu, patariama naudotis viešuoju transportu.
              </th>
            <tr class="bg-aqi_purple text-white border-b border-gray-700">
              <th scope="row" class="px-2 py-4 font-medium ">
                Violetinė
              </th>
              <th scope="row" class="px-2 py-4 font-medium ">
                Stenkitės kuo mažiau būti atvirame ore; būdami patalpose, neatidarykite langų; pajutę sveikatos
                sutrikimus, kreipkitės į gydytoją.
              </th>
            </tr>
          </tbody>
        </table>
      </div>

    </div>




    <x-border-line class="xl:col-span-2 col-span-1">Diagramos</x-border-line>

    <div class="xl:col-span-2 col-span-1">
      <x-text_info>Žemiau nurodyti aplinkos taršos rodikliai tyrimo vietovėje ir tyrimo metu. (Duomenys gauti iš
        OpenWeatherMap. NH3 ir NO nėra pažįmėti spalvomis,
        kadangi neturi įtakos oro kokybės indekso skaičiavimui pagal OpenWeatherMap algoritmą). Po šiais rodikliais
        parodyti realūs matavimai diagramoje</x-text_info>

      <div class="flex-row justify-center">
        <div class="text-xl text-center self-center">Oro taršos parodymai iš aplinkos stočių</div>
        <div class="text-center">@foreach($pastPollution['list'] as $row)(Duomenys surinkti:
          <?php echo date('Y-m-d H:i:s', $row['dt']); ?>)
          @endforeach
        </div>
        <div class="flex xl:flex-nowrap flex-wrap xl:justify-between justify-center gap-6">
          @foreach($pastPollution['list'] as $list)
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['main']['aqi'], 'limits' => [1,2,3,4,5]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight ">OKI</h5>
            <p class="font-normal">Oro kokybės indeksas</p>
            <p class="font-bold ">{{$list['main']['aqi']}}</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['co'], 'limits' => [0,4400,9400,12400,15400]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight ">CO</h5>
            <p class="font-normal">Anglies monoksidas</p>
            <p class="font-bold ">{{$list['components']['co']}} µg/m3</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['o3'], 'limits' => [0,40,70,150,200]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight ">O3</h5>
            <p class="font-normal">Ozonas</p>
            <p class="font-bold ">{{$list['components']['o3']}} µg/m3</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['pm2_5'], 'limits' => [0,10,25,50,75]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight ">KD2.5</h5>
            <p class="font-normal">Kietosios dalelės</p>
            <p class="font-bold ">{{$list['components']['pm2_5']}} µg/m3</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['pm10'], 'limits' => [0,20,50,100,200]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight ">KD10</h5>
            <p class="font-normal">Kietosios dalelės</p>
            <p class="font-bold ">{{$list['components']['pm10']}} µg/m3</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['no2'], 'limits' => [0,40,70,150,200]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight">NO2</h5>
            <p class="font-normal">Azoto dioksidas</p>
            <p class="font-bold ">{{$list['components']['no2']}} µg/m3</p>
          </div>
          <div
            class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['so2'], 'limits' => [0,20,80,250,350]])">
            <h5 class="mb-2 text-2xl font-bold tracking-tight">SO2</h5>
            <p class="font-normal">Sieros dioksidas</p>
            <p class="font-bold ">{{$list['components']['so2']}} µg/m3</p>
          </div>
          <div class="shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center bg-white">
            <h5 class="mb-2 text-2xl font-bold tracking-tight">NH3</h5>
            <p class="font-normal">Amoniakas</p>
            <p class="font-bold ">{{$list['components']['nh3']}} µg/m3</p>
          </div>
          <div class="px-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center bg-white">
            <h5 class="mb-2 text-2xl font-bold tracking-tight">NO</h5>
            <p class="font-normal">Azoto monoksidas</p>
            <p class="font-bold ">{{$list['components']['no']}} µg/m3</p>
          </div>
          @endforeach
        </div>
      </div>

    </div>
    <div class="xl:col-span-2 col-span-1 w-full grid grid-cols-12 place-items-center">
      <div class="xl:col-span-9 col-span-12 w-full">
        <canvas id="myChart" class="lolas  h-[600px]"></canvas>
      </div>
      <div class="xl:col-span-3 col-span-12 w-full rounded-lg overflow-hidden shadow-lg shadow-indigo-500/50">
        <table class="tarsos_taskai w-full text-sm text-left">
          <thead class="uppercase border-b border-gray-700">
            <tr>
              Spalvos pagal teršalų koncentracijos dydį
            </tr>
          </thead>
          <thead class="uppercase border-b border-gray-700">
            <tr>
              <th scope=" col" class="py-4">
                SO2
              </th>
              <th scope="col" class="py-4">
                NO2
              </th>
              <th scope="col" class="py-4">
                PM10
              </th>
              <th scope="col" class="py-4">
                PM2.5
              </th>
              <th scope="col" class="py-4">
                O3
              </th>
              <th scope="col" class="py-4">
                CO
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-aqi_green border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                0-20
              </th>
              <td class="py-4">
                0-40
              </td>
              <td class="py-4">
                0-20
              </td>
              <td class="py-4">
                0-10
              </td>
              <td class="py-4">
                0-60
              </td>
              <td class="py-4">
                0-4400
              </td>
            </tr>
            <tr class="bg-aqi_yellow border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                20-80
              </th>
              <td class="py-4">
                40-70
              </td>
              <td class="py-4">
                20-50
              </td>
              <td class="py-4">
                10-25
              </td>
              <td class="py-4">
                60-100
              </td>
              <td class="py-4">
                4400-9400
              </td>
            </tr>
            <tr class="bg-aqi_orange text-white border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                80-250 </th>
              <td class="py-4">
                70-150 </td>
              <td class="py-4">
                50-100 </td>
              <td class="py-4">
                25-50 </td>
              <td class="py-4">
                100-140 </td>
              <td class="py-4">
                9400-12400
              </td>
            </tr>
            <tr class="bg-aqi_red text-white border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                250-350 </th>
              <td class="py-4">
                150-200 </td>
              <td class="py-4">
                100-200 </td>
              <td class="py-4">
                50-75 </td>
              <td class="py-4">
                140-180 </td>
              <td class="py-4">
                12400-15400
              </td>
            </tr>
            <tr class="bg-aqi_purple text-white border-b border-gray-700">
              <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                >350 </th>
              <td class="py-4">
                >200 </td>
              <td class="py-4">
                >200 </td>
              <td class="py-4">
                >75 </td>
              <td class="py-4">
                >180 </td>
              <td class="py-4">
                >15400

              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-span-1">
      <canvas id="CO2Chart" class="lolas w-full h-[300px]"></canvas>
    </div>
    <div class="col-span-1">
      <canvas id="altitudeChart" class="lolas w-full h-[300px]"></canvas>
    </div>


    <x-border-line class="xl:col-span-2 col-span-1">Skrydžio ir taršos duomenys žemelapyje</x-border-line>

    <x-text_info>Žemiau pateikiamas žemėlapis su stačiakampių matrica/tinkeliu. Kiekviename stačiakampyje yra
      apskaičiuota vidutinė taršos reikšmė, tame plote, kurį apima stačiakampis.</x-text_info>


    <div class="xl:col-span-2 col-span-1 ">
      <div class="text-center text-xl">Matavimų lygis skirtingose vietose</div>
      <div id="map5" class="h-[500px] mx-auto" style="height: 500px; width: 60%;"></div>
      <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
          image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 326.85"
          class="w-6 h-6">
          <path fill-rule="nonzero"
            d="M307.56 301.51c.51 10.05 3.9 17.2 10.19 21.35 15.76 10.52 31.28-1.96 42.64-12.05L502.5 183.04c12.67-11.46 12.67-27.76 0-39.22L363.62 18.96c-11.9-10.69-28.78-26.39-45.87-14.99-6.29 4.17-9.68 11.33-10.19 21.38v76.31H6.33c-3.48 0-6.33 2.85-6.33 6.33v110.88c0 3.47 2.86 6.33 6.33 6.33h301.23v76.31z" />
        </svg>
        <p> Vėjas {{$cardinal}} {{$windSpeed}} m/s</p>
      </div>
      <div class="flex justify-center">
        <div class="w-72 text-center">
          <p class="">Spalvų reikšmės pagal CO2 PPM</p>
          <div class="flex justify-between mx-auto">
            <div class="w-14 h-6 bg-aqi_green"></div>
            <div class="w-14 h-6 bg-aqi_yellow"></div>
            <div class="w-14 h-6 bg-aqi_orange"></div>
            <div class="w-14 h-6 bg-aqi_red"></div>
            <div class="w-14 h-6 bg-aqi_purple"></div>
          </div>
          <div class="flex w-64 justify-between">
            <p>400</p>
            <p>1000</p>
            <p>2000</p>
            <p>5000</p>
            <p>
              40000</p>
          </div>
        </div>
      </div>
    </div>

  </div>


</div>
@php $api = 'a1f1c82b022e408d160b9d8afd2c0d43'; @endphp

@php

@endphp
<script>
  const config = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
          datasets: [{
                  label: 'NO2',
                  data: <?php echo json_encode($no2); ?>,
                  borderColor: "#e60049",
                  fill: false,
                  tension: 0.1
                  },
                  {
                  label: 'SO2',
                  data: <?php echo json_encode($so2); ?>,
                  fill: false,
                  borderColor: "#0bb4ff",
                  tension: 0.1
                  },
                  {
                  label: 'KD10',
                  data: <?php echo json_encode($pm10); ?>,
                  fill: false,
                  borderColor: "#50e991",
                  tension: 0.1
                  },
                  {
                  label: 'KD2.5',
                  data: <?php echo json_encode($pm2_5); ?>,
                  fill: false,
                  borderColor: "#e6d800",
                  tension: 0.1
                  },
                  {
                  label: 'O3',
                  data: <?php echo json_encode($o3); ?>,
                  fill: false,
                  borderColor: "#9b19f5",
                  tension: 0.1
                  },
                  {
                  label: 'CO',
                  data: <?php echo json_encode($co); ?>,
                  fill: false,
                  borderColor: "#ffa300",
                  tension: 0.1
                  },
                ],
      },
      options: {
        responsive: true,
            maintainAspectRatio: false,
        plugins: {
      title: {
        display: true,
        text: 'Matavimų priklausomybė nuo laiko',
        color: "#000000",
        font: {
            size: 20,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
      }
    },
        scales:{
          x: {
        display: true,
        title: {
          display: true,
          text: 'Tyrimo laikas (valanda, minutė, sekundė)',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
        },
        },
        y: {
        display: true,
        title: {
          display: true,
          text: 'Matavimo rodikliai µg/m3',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2
          },
        }
      }
  },
        elements: {
                    point:{
                        radius: 0
                    },
                    line:{
                      borderWidth: 6
                    }
                  },
        interaction:{
          intersect: false,
          mode: 'index',
        }
      },
  };

  const ctx = document.getElementById('myChart');
  const chart = new Chart(ctx, config);
</script>

<script>
  const config1 = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
          datasets: [{
                  label: 'Aukšis',
                  data: <?php echo json_encode($altitude); ?>,
                  fill: false,
                  borderColor: "#e60049",
                  tension: 0.1
                  },
                ],
      },
      options: {
        responsive: true,
            maintainAspectRatio: false,
        plugins: {
      title: {
        display: true,
        text: 'Matavimų aukščio priklausomybė nuo laiko',
        color: "#000000",
        font: {
            size: 20,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
      }
    },
        scales:{
          x: {
        display: true,
        title: {
          display: true,
          text: 'Tyrimo laikas (valanda, minutė, sekundė)',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
        },
        },
        y: {
        display: true,
        title: {
          display: true,
          text: 'Aukštis m',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2
          },
        }
      }
  },
        elements: {
                    point:{
                        radius: 0
                    },
                    line:{
                      borderWidth: 6
                    }
                  },
        interaction:{
          intersect: false,
          mode: 'index',
        }
      },
  };

  const ctx1 = document.getElementById('altitudeChart');
  const chart1 = new Chart(ctx1, config1);
</script>

<script>
  const config2 = {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
          datasets: [{
                  label: 'CO2',
                  data: <?php echo json_encode($sensor1); ?>,
                  fill: false,
                  borderColor: "#e60049",
                  tension: 0.1
                  },
                ],
      },
      options: {
        responsive: true,
            maintainAspectRatio: false,
        plugins: {
      title: {
        display: true,
        text: 'CO2 matavimų reikšmių priklausomybė nuo laiko',
        color: "#000000",
        font: {
            size: 20,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
      }
    },
        scales:{
          x: {
        display: true,
        title: {
          display: true,
          text: 'Tyrimo laikas (valanda, minutė, sekundė)',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2,
            
          },
        },
        },
        y: {
        display: true,
        title: {
          display: true,
          text: 'CO2 PPM',
          font: {
            size: 18,
            weight: 'bold',
            lineHeight: 1.2
          },
        }
      }
  },
        elements: {
                    point:{
                        radius: 0
                    },
                    line:{
                      borderWidth: 6
                    }
                  },
        interaction:{
          intersect: false,
          mode: 'index',
        }
      },
  };

  const ctx2 = document.getElementById('CO2Chart');
  const chart2 = new Chart(ctx2, config2);
</script>

<script>
  const pollutionData = [
    @foreach($droneAndSensorData as $row)
    { lat: {{$row->latitude}}, lng: {{$row->longitude}}, pollution: {{$row->sensor1}} , altitude: {{$row->altitude}}},
    @endforeach
  ];

  var map = L.map('map5').setView([{{$droneAndSensorData[$coordinateCenter]->latitude}}, {{$droneAndSensorData[$coordinateCenter]->longitude}}], 16);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  
  const gridSize = 0.0001;
const latMin = {{$minLat}};
const latMax = {{$maxLat}};
const lngMin = {{$minLng}};
const lngMax = {{$maxLng}};

function getColor(pollution) {
  return pollution >= 40000 ? '#8F3F97' :
         pollution >= 5000 ? '#ff0000' :
         pollution >= 2000 ? '#ff7e00' :
         pollution >= 1000  ? '#ffff00' :
         pollution > 400  ? '#00e400': '#00FF0000' ;

                          
}

for (let lat = latMin; lat <= latMax; lat += gridSize) {
  for (let lng = lngMin; lng <= lngMax; lng += gridSize) {
    const { averagePollution, averageAltitude } = getAverages(lat, lng, gridSize);
    const rectangle = L.rectangle([[lat, lng], [lat + gridSize, lng + gridSize]], {
      color: getColor(averagePollution),
      weight: 1,
      fillColor: getColor(averagePollution),
      fillOpacity: 0.7
    });

    rectangle.bindPopup(`<b>Vidutiniai matavimai šiame plote:</b> ${averagePollution.toFixed(2)} PPM, vidutinis matavimo aukštis:  ${averageAltitude.toFixed(2)}m`);
    rectangle.on('click', (e) => {
  rectangle.openPopup();
});


rectangle.on('mouseover', (e) => {
  rectangle.setStyle({
    color: getColor(averagePollution),
    fillColor: getColor(averagePollution),
    fillOpacity: 0.2
  });
});

rectangle.on('mouseout', (e) => {
  rectangle.setStyle({
    color: getColor(averagePollution),
    fillColor: getColor(averagePollution),
    fillOpacity: 0.7
  });
});
    rectangle.addTo(map);
  }
}

function getAverages(lat, lng, gridSize) {
  const bounds = {
    latMin: lat,
    latMax: lat + gridSize,
    lngMin: lng,
    lngMax: lng + gridSize
  };

  const measurementsInSquare = pollutionData.filter(measurement => {
    return measurement.lat >= bounds.latMin &&
           measurement.lat <= bounds.latMax &&
           measurement.lng >= bounds.lngMin &&
           measurement.lng <= bounds.lngMax;
  });

  const totalPollution = measurementsInSquare.reduce((sum, measurement) => sum + measurement.pollution, 0);
  const averagePollution = totalPollution / measurementsInSquare.length;
  const totalAltitude = measurementsInSquare.reduce((sum, measurement) => sum + measurement.altitude, 0);
  const averageAltitude = totalAltitude / measurementsInSquare.length;

  return { averagePollution, averageAltitude };
}


L.tileLayer(@php echo "'$windApi'," @endphp {
  opacity: 0.45
}).addTo(map);


</script>

@else
<p>Klaida! Įkeltuose failuose nėra duomenų arba nėra sutampančių laiko eilučių</p>

@endunless


@endsection